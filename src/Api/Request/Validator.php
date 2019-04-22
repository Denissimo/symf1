<?php

namespace App\Api\Request;

use App\Exceptions\InactiveCliendException;
use App\Exceptions\InvalidRequestAgrs;
use App\Exceptions\MalformedApiKeyException;
use App\Helpers\Output;
use App\Proxy;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;
use App\Exceptions\MalformedRequestException;
use App\Api\Fields as Api;
use Symfony\Component\HttpFoundation\Request;

class Validator
{
    const
        DATA = 'data',
        RESPONSE = 'response';

    /**
     * @param Request $Request
     * @param array $requiredFields
     * @param bool $post
     */
    public function validateRequiredFields(Request $Request, array $requiredFields, $post = false)
    {
        Proxy::init()->getValidator()->validateRequired(
            $post ? $Request->request->all() : $Request->query->all(),
            $requiredFields,
            'Required fields missing: ' . implode(', ', $requiredFields),
            MalformedRequestException::class
        );
    }


    public function validateClientActive(\ClientSettings $client)
    {
        Proxy::init()->getValidator()->validateType(
            [self::DATA => $client->getActive()],
            [
                self::DATA => new Assert\EqualTo(\ClientSettings::VALUE_ACTIVE)
            ],
            'Inactive cletnt !',
            InactiveCliendException::class
        );
    }

    /**
     * @param $object
     * @param $errorMessage
     */
    public function validateNotBlank($object, $errorMessage)
    {
        Proxy::init()->getValidator()->validateType(
            [self::DATA => $object],
            [
                self::DATA => new Assert\NotBlank()
            ],
            $errorMessage,
            MalformedRequestException::class
        );
    }


    /**
     * @param $object
     * @param $errorMessage
     */
    public function validateApiKey($object, $errorMessage)
    {
        Proxy::init()->getValidator()->validateType(
            [self::DATA => $object],
            [
                self::DATA => new Assert\NotBlank()
            ],
            $errorMessage,
            MalformedApiKeyException::class
        );
    }

    /**
     * @param int $diff
     * @param int $days
     */
    public function validateDateDiff($diff, $days)
    {
        Proxy::init()->getValidator()->validate(
            $diff,
            new Assert\LessThan($days),
            'Date interval over ' . $days . ' days',
            MalformedRequestException::class
        );
    }

    /**
     * Валидация данных для создания заказа
     *
     * @param array $post
     * @param bool $isOff
     * @return array
     * @throws InvalidRequestAgrs
     */
    public function validateCreateOrder(array $post, bool $isOff)
    {
        $requiredFields = [
            Api::ADDR,
            Api::GOODS,
            Api::NP,
            Api::PRICE_CLIENT,
            Api::OS,
            Api::DELIVERY_DATE,
            Api::DELIVERY_TIME
//            Api::PRICE_CLIENT_DELIVERY_NDS
        ];

        Proxy::init()->getValidator()->validateRequired(
            $post,
            $requiredFields,
            'Поля ' . implode(', ', $requiredFields) . ' обязаиельны для заполнения!',
            MalformedRequestException::class
        );
/*
        Proxy::init()->getValidator()->validate(
            $post,
            new Assert\
        );
*/
        if (empty($post[Api::MO_PUNKT_ID]) && empty($post[Api::CITY])) {
            throw new InvalidRequestAgrs(sprintf("Не заполнено одно из полей %s или %s", Api::MO_PUNKT_ID, Api::CITY));
        }


        if ($isOff) {
            // вычесляем сумму за все goods
            $goodsTotal = 0;
            foreach ($post[Api::GOODS] as $key => $good) {
                if (!isset($good[Api::COUNT]) || empty($good[Api::COUNT])) {
                    throw new InvalidRequestAgrs("Goods[$key] - ошибка кол-ва");
                }
                $goodsTotal += $good[Api::COUNT] * $good[Api::PRICE];
            }

            // проверяем валидность прайса при наложенном платеже
            if (intval($post[Api::NP]) === 1) {
                $goodsTotal += $post[Api::PRICE_CLIENT_DELIVERY];
                if (floatval($goodsTotal) !== floatval($post[Api::PRICE_CLIENT])) {
                    throw new InvalidRequestAgrs(Api::PRICE_CLIENT . " != сумме товаров $goodsTotal + доставка");
                }
                dd(floatval($goodsTotal), floatval($post[Api::PRICE_CLIENT]));
            }
        }

        // валидируем дату доставки
        $toDay = Carbon::now();
        $deliveryDate = Carbon::createFromFormat(\Orders::DELIVERY_DATE_FORMAT, $post[Api::DELIVERY_DATE]);

        // если дата доставки меньше текущего дня
        if ($deliveryDate->format(\Orders::DELIVERY_DATE_FORMAT) < $toDay->format(\Orders::DELIVERY_DATE_FORMAT)) {
            $deliveryDate = $toDay->clone();
        }

        // если больше 3 часов, доставка переносится на следующий день
        if ($toDay->hour >= 3) {
            $deliveryDate = $deliveryDate->addDay();
        }
        $post[Api::DELIVERY_DATE] = $deliveryDate;

        // валидация времени доставки
        if (!in_array($post[Api::DELIVERY_TIME], [1, 2, 3, 4])) {
            throw new InvalidRequestAgrs('Значение ' . Api::DELIVERY_TIME . ' должно быть в диапазоне 1-4');
        }

        // валидация НДС
        /*
        1 - HДС 18% (упраздняется),
        2 - Без HДС,
        3 - HДС 10%,
        4 - HДС 18/118 (упраздняется),
        5 - HДС 10/110,
        6 - НДС 0%,
        7 - НДС 20% с 1 янаваря 2019 года
        8 - НДС 20/120 - с 1го января 2019 года
        */
        if (!in_array($post[Api::PRICE_CLIENT_DELIVERY_NDS], [2, 3, 5, 6, 7, 8])) {
            throw new InvalidRequestAgrs('Значение ' . Api::PRICE_CLIENT_DELIVERY_NDS . ' должно содержать одно из значений: 2, 3, 5, 6, 7, 8');
        }

        // размеры груза
        if (empty((int)$post[Api::DIMENSION_SIDE_1])) {
            $post[Api::DIMENSION_SIDE_1] = 10;
        }
        if (empty((int)$post[Api::DIMENSION_SIDE_2])) {
            $post[Api::DIMENSION_SIDE_2] = 10;
        }
        if (empty((int)$post[Api::DIMENSION_SIDE_3])) {
            $post[Api::DIMENSION_SIDE_3] = 10;
        }
        if (empty((int)$post[Api::ORDER_WEIGHT])) {
            $post[Api::ORDER_WEIGHT] = 1;
        }

        return $post;
    }

}