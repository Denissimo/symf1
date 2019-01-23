<?php

namespace App\Controller\Criteria;

use App\Controller\Actions\Autorize;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\CompositeExpression;
use Doctrine\Common\Collections\Expr\Comparison;
use App\Controller\MainController as Controller;
use Symfony\Component\HttpFoundation\Request;


class Builder
{

    const
        TIME_ZERO = '_00:00:00',
        TIME_NIGHT = '_23:59:59',
        TPL_DATE_TIME = 'd.m.Y_H:i:s';

    private $orderFields = [
        'id1' => ['id' => 'ASC'],
        'id2' => ['id' => 'DESC'],
        'createdAt1' => ['createdat' => 'ASC'],
        'createdAt2' => ['createdat' => 'DESC'],
        'updatedAt1' => ['updatedat' => 'ASC'],
        'updatedAt2' => ['updatedat' => 'DESC'],
    ];

    /**
     * @param Request $request
     * @return Criteria
     */
    public function appsCommon(Request $request): Criteria
    {
        $filter = $request->get('filter');
        $criteria = Criteria::create();
        $criteria->where(
//            Criteria::expr()->eq('inWork', 1)
            Criteria::expr()->neq('id', 0)
        );
        if ($filter == 'trash') {
            $criteria->andWhere(
                Criteria::expr()->eq('trash', 1)
            );
        } else {
            if ($filter == 'new') {
                $criteria->andWhere(
                    Criteria::expr()->eq('inWork', 0)
                );
            } elseif($filter == 'worknew') {
//                $criteria->andWhere(
//                    Criteria::expr()->in('inWork', [0,1])
//                );
            }else {
                $criteria->andWhere(
                    Criteria::expr()->eq('inWork', 1)
                );
            }
            $criteria->andWhere(
                Criteria::expr()->eq('trash', 0)
            );
        }

/*
        $criteria->andWhere(
            Criteria::expr()->eq('trash', 0)
        );
*/
        //$criteria = $this->addWhere($criteria, $request);
//        var_dump(\DateTime::createFromFormat('Ymd', '20180104')); die;
//        echo "<pre>";var_dump($this->initExpressions($request)); echo "</pre>"; die;
        foreach ($this->initExpressions($request) as $expression) {
            if ($expression) {
                $criteria->andWhere($expression);
            }
        }
        /*
                $criteria->andWhere(
                    Criteria::expr()->gte(
                        'createdat',
                        \DateTime::createFromFormat('Ymdhis', '20180103055050')
                    )
                );
        */
        $allApps = (new Autorize())->getAccessList()[Autorize::ACCESS_ALL_APPS];
//        var_dump($allApps); die;
//        var_dump((new Autorize())->getUserId()); die;
        if (!$allApps) {
            $criteria->andWhere(Criteria::expr()->eq('userId', (new Autorize())->getUserId()));
        }

        $criteria->orderBy(['status' => 'ASC', 'updatedat' => 'DESC', 'id' => 'DESC']);

        $criteria->setMaxResults(
            (int)$request->get(Controller::LIMIT) ? (int)$request->get(Controller::LIMIT) : Controller::DEFAULT_LIMIT
        );

        return $criteria;
    }


    /**
     * @param Request $request
     * @return array
     */
    private function initExpressions(Request $request): array
    {
        return [
            Controller::CREATE_AT => $this->buildPeriod($request, Controller::CREATE_AT),
            Controller::UPDATE_AT => $this->buildPeriod($request, Controller::UPDATE_AT),
            Controller::USER_ID =>
                $request->get(Controller::USER_ID) ?
                    Criteria::expr()->eq(Controller::USER_ID, $request->get(Controller::USER_ID)) : null,
            Controller::PARTNER_ID =>
                $request->get(Controller::PARTNER_ID) ?
                    Criteria::expr()->eq(Controller::PARTNER_ID, $request->get(Controller::PARTNER_ID)) : null,
        ];

    }

    /**
     * @param Request $request
     * @param string $field
     * @return CompositeExpression | Comparison | null
     */
    private function buildPeriod(Request $request, string $field)
    {
        $from = $request->get(Controller::$fields[$field][Controller::FROM]);
        $to = $request->get(Controller::$fields[$field][Controller::TO]);
//        var_dump(Controller::$fields[$field]);
        if ($from && $to) {
//            var_dump($from); var_dump($to);die;
            return Criteria::expr()->andX(
                Criteria::expr()->gte(
                    $field,
                    \DateTime::createFromFormat(self::TPL_DATE_TIME, $from . self::TIME_ZERO)
                ),
                Criteria::expr()->lte(
                    $field,
                    \DateTime::createFromFormat(self::TPL_DATE_TIME, $to . self::TIME_NIGHT)
                )
            );
        } elseif ($from) {
            return Criteria::expr()->gte(
                $field,
                \DateTime::createFromFormat(self::TPL_DATE_TIME, $from . self::TIME_ZERO)
            );
        } elseif ($to) {
            return Criteria::expr()->lte(
                $field,
                \DateTime::createFromFormat(self::TPL_DATE_TIME, $to . self::TIME_NIGHT)
            );
        } else {
            return null;
        }
    }

}