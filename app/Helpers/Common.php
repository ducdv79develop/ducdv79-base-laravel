<?php

namespace App\Helpers;

use App\Config\AppConstants;
use App\Models\Transaction;
use Carbon\Carbon;
use Throwable;

class Common
{
    /**
     * Encryption Data Input.
     *
     * @param mixed $data
     * @return string
     */
    public static function cryptData($data): string
    {
        return base64_encode($data);
    }

    /**
     * Encryption Data Input.
     *
     * @param mixed $data
     * @return string
     */
    public static function decryptData($data): string
    {
        return base64_decode($data);
    }

    /**
     * @param $status
     * @return string
     */
    public static function classStatusTransaction($status): string
    {
        switch ($status) {
            case AppConstants::TRANS_CANCEL:
                return 'status--cancel';
            case AppConstants::TRANS_HAPPENING:
                return 'status--warning';
            default:
                return 'status--success';
        }
    }

    /**
     * @param $data
     * @return string
     */
    public static function textStatusTransaction($data): string
    {
        $text = __('message.transaction.status');
        if ($data && key_exists($data->status, $text)) {
            return $text[$data->status];
        }
        return $text['no_data'];
    }

    /**
     * @param $breadcrumbs
     * @param string $title
     * @return array|string
     * @throws Throwable
     */
    public static function getBreadcrumb($breadcrumbs, $title = '')
    {
        return view('admin.common.breadcrumb', compact('breadcrumbs', 'title'))->render();
    }

    /**
     * @param null $timeout
     * @param false $date
     * @return string
     */
    public static function accountTimeout($timeout = null, bool $date = false): string
    {
        if (empty($timeout)) {
            return ZERO_VALUE;
        }
        $current = Carbon::now(config('app.timezone'))->format('Y-m-d');

        if ($timeout >= $current) {
            $datetime1 = date_create($timeout);
            $datetime2 = date_create($current);
            $interval = date_diff($datetime1, $datetime2);

            return number_format($interval->days + 1) . ($date ? ' ' . __('message.common.day') : '');
        }

        return ZERO_VALUE . ($date ? ' ' . __('message.common.day') : '');
    }

    /**
     * @param $gender
     * @return string
     */
    public static function textGender($gender): string
    {
        switch ($gender) {
            case 0:
                return 'không xác định';
            case 1:
                return 'nam';
            case 2:
                return 'nữ';
            default:
                return '';
        }
    }

    /**
     * @param $status
     * @return string
     */
    public static function textBorrowerStatus($status): string
    {
        switch ($status) {
            case 1:
                return '<span class="status--success">hoạt động</span>';
            case 2:
                return '<span class="color--red">đã xóa</span>';
            case 3:
                return '<span class="status--warning">cảnh báo chú ý</span>';
            case 4:
                return '<span class="color--red">cảnh báo nguy hiểm</span>';
            case 5:
                return '<span class="color--red">cảnh báo rất nguy hiểm</span>';
            default:
                return '';
        }
    }

    /**
     * @param $price
     * @return string
     */
    public static function showPriceNumber($price): string
    {
        return number_format($price) . ' K';
    }

    /**
     * @param $data
     * @return string
     */
    public static function textMemberStatus($data): string
    {
        if (empty($data) || !is_object($data)) return '';

        $timeout = self::accountTimeout($data->timeout, true);
        if ($timeout <= ZERO_VALUE) {
            $status = 'timeout';
        } else {
            $status = $data->status;
        }
        switch ($status) {
            case AppConstants::ADM_STATUS_ACTIVE:
                return '<span class="status--success"><i class="fas fa-circle" style="font-size: 10px;"></i> '
                    . __('Account Active') . '</span>';
            case AppConstants::ADM_STATUS_BLOCK:
                return '<span class="color--red"><i class="fas fa-circle" style="font-size: 10px;"></i> '
                    . __('Account Block') . '</span>';
            case AppConstants::ADM_STATUS_REMOVE:
                return '<span class="color--red"><i class="fas fa-circle" style="font-size: 10px;"></i> '
                    . __('Account Remove') . '</span>';
            case 'timeout':
                return '<span class="status--warning"><i class="fas fa-circle" style="font-size: 10px;"></i> '
                    . __('Account Timeout') . '</span>';
            default:
                return '';
        }
    }

    /**
     * @param $type
     * @return string
     */
    public static function textTypeTransaction($type): string
    {
        $text = __('message.transaction.type_text');
        if (key_exists($type, $text)) {
            return ' (' . $text[$type] . ') ';
        }
        return '';
    }

    /**
     * @param $transaction
     * @return string
     */
    public static function textStatusTransDay($transaction): string
    {
        if (!empty($transaction->transactionToday->first())) {
            if ($transaction->transactionToday->first()->status == AppConstants::TRANS_COLLECTED) {
                return '<span class="status--success">Đã thu</span>';
            }
            return '<span class="status--cancel">Đã thu</span>';
        }
        return '<span class="status--warning">Chưa thu</span>';
    }

    /**
     * @param $transaction
     * @param null $result
     * @return array|int|mixed
     */
    public static function sumCollectedTransDay($transaction, $result = null)
    {
        $collectedNum = 0;
        $dateCollectedCount = 0;
        $countTotalDate = self::getCountDate($transaction->type);

        if (!empty($transaction->transactionDaysAdd)) {
            $transactionDays = $transaction->transactionDaysAdd;
        } elseif (!empty($transaction->transactionDays) && !$transaction->transactionDays->isEmpty()) {
            $transactionDays = $transaction->transactionDays;
        }
        if (!empty($transactionDays)) {
            $collectedNum = $transactionDays
                ->where('status', AppConstants::TRANS_COLLECTED)
                ->sum('amount');
            $dateCollectedCount = $transactionDays
                ->where('status', AppConstants::TRANS_COLLECTED)
                ->count();
        }
        switch ($result) {
            case AppConstants::TRANS_TOTAL_AMOUNT:
                return $collectedNum;
            case AppConstants::TRANS_TOTAL_DATE:
                return $countTotalDate;
            case AppConstants::TRANS_DATE_COLLECT:
                return $dateCollectedCount;
            case AppConstants::TRANS_DATE_UNCOLLECTED:
                return $countTotalDate - $dateCollectedCount;
            default:
                return [
                    AppConstants::TRANS_TOTAL_AMOUNT => $collectedNum,
                    AppConstants::TRANS_TOTAL_DATE => $countTotalDate,
                    AppConstants::TRANS_DATE_COLLECT => $dateCollectedCount,
                    AppConstants::TRANS_DATE_UNCOLLECTED => $countTotalDate - $dateCollectedCount
                ];
        }
    }

    /**
     * @param $type
     * @return int
     */
    public static function getCountDate($type): int
    {
        switch ($type) {
            case AppConstants::TRANS_30_DAY:
                return 30;
            case AppConstants::TRANS_40_DAY:
                return 40;
            case AppConstants::TRANS_50_DAY:
                return 50;
            case AppConstants::TRANS_60_DAY:
                return 60;
            default:
                return 0;
        }
    }

    /**
     * @param $start
     * @param $end
     * @return string
     */
    public static function periodTransaction($start, $end): string
    {
        $start = date('d-m-Y', strtotime($start));
        $end = date('d-m-Y', strtotime($end));

        return "$start ~ $end";
    }

    /**
     * @param $time
     * @return string
     */
    public static function howLongAgo($time): string
    {
        $time_difference = time() - strtotime($time);

        if ($time_difference < 1) {
            return __('message.common.just_now');
        }
        $condition = array(12 * 30 * 24 * 60 * 60 => __('message.common.year'),
            30 * 24 * 60 * 60 => __('message.common.month'),
            24 * 60 * 60 => __('message.common.day'),
            60 * 60 => __('message.common.hour'),
            60 => __('message.common.minute'),
            1 => __('message.common.second'),
        );

        foreach ($condition as $secs => $str) {
            $d = $time_difference / $secs;

            if ($d >= 1) {
                $t = round($d);
                return __('message.common.about') . ' ' . $t . ' ' . $str . ' ' . __('message.common.ago');
            }
        }
        return '';
    }

    /**
     * @param $info
     * @return string
     */
    public static function urlPathAvatar($info): string
    {
        if (!is_object($info)) {
            return asset('admin/main/image/avatar_default_1.png');
        }

        if (!empty($info->avatar_path)) {
            $dataUrl = GoogleDriveHelpers::getImage($info->avatar_path);
        }
        if (empty($dataUrl)) {
            if ($info->gender == AppConstants::GENDER_FEMALE) {
                $dataUrl = asset('admin/main/image/avatar_default_2.png');
            } else {
                $dataUrl = asset('admin/main/image/avatar_default_1.png');
            }
        }
        return $dataUrl;
    }
}
