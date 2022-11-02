<?php

namespace App\Helpers;

use App\Config\AppConstants;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Htmlable;
use App\Exceptions\ColumnSortableException;
use Modules\Finance\Config\FinanceConstants;

class SortableLink
{
    private static $color = '#212529';
    /**
     * @var string[]
     */
    protected static $requestExcepts = [
        'sort',
        'direction',
        'page',
        AppConstants::DEFINE_ACTION_REQUEST,
        AppConstants::ADM_KEY_REQUEST,
    ];

    /**
     * @param array $parameters
     * @return string
     * @throws Exception
     */
    public static function render(array $parameters): string
    {
        list($sortColumn, $sortParameter, $title) = self::parseParameters($parameters);
        $title = self::applyFormatting($title, $sortColumn);
        list($icon, $direction) = self::determineDirection($sortColumn, $sortParameter);
        $trailingTag = self::formTrailingTag($icon);
        $queryString = self::buildQueryString($sortParameter, $direction);
        return '<a style="color: '. self::$color . '" href="'.url(request()->path().'?'.$queryString).'">'.$title.$trailingTag;
    }

    /**
     * @param $sortParameter
     * @param $direction
     * @return string
     */
    private static function buildQueryString($sortParameter, $direction): string
    {
        $checkStrLenOrArray = function ($element) {
            return is_array($element) ? $element : strlen($element);
        };
        $persistParameters = array_filter(request()->except(self::$requestExcepts), $checkStrLenOrArray);
        return http_build_query(array_merge($persistParameters, [
            'sort' => $sortParameter,
            'direction' => $direction,
        ]));
    }

    /**
     * @param array $parameters
     * @return array
     * @throws Exception
     */
    public static function parseParameters(array $parameters): array
    {
        $explodeResult = self::explodeSortParameter($parameters[0]);
        $sortColumn = (empty($explodeResult)) ? $parameters[0] : $explodeResult[1];
        $title = (count($parameters) === 1) ? null : $parameters[1];
        return [$sortColumn,$sortColumn, $title];
    }

    /**
     * Explodes parameter if possible and returns array [column, relation]
     * Empty array is returned if explode could not run eg: separator was not found.
     * @param $parameter
     * @return array
     * @throws Exception
     */
    public static function explodeSortParameter($parameter): array
    {
        $separator = '.';
        if (Str::contains($parameter, $separator)) {
            $oneToOneSort = explode($separator, $parameter);
            if (count($oneToOneSort) !== 2) {
                throw new ColumnSortableException();
            }
            return $oneToOneSort;
        }
        return [];
    }

    /**
     * @param string|Htmlable|null $title
     * @param string $sortColumn
     * @return string
     */
    private static function applyFormatting($title, string $sortColumn)
    {
        if ($title instanceof Htmlable) {
            return $title;
        }

        if ($title === null) {
            $title = $sortColumn;
        } elseif ( ! true ){
            return $title;
        }
        return $title;
    }

    /**
     * @param $sortColumn
     * @param $sortParameter
     * @return array
     */
    private static function determineDirection($sortColumn, $sortParameter): array
    {
        $icon = self::selectIcon();
        if (request('sort') == $sortParameter && in_array(request('direction'), ['asc', 'desc'])) {
            $icon      .= (request('direction') === 'asc' ? '-up' : '-down');
            $direction = request('direction') === 'desc' ? 'asc' : 'desc';
            return [$icon, $direction];
        }  else {
            $icon      = 'fa fa-sort';
            $direction = 'asc';
            return [$icon, $direction];
        }
    }

    /**
     * @return string
     */
    private static function selectIcon(): string
    {
        return 'fa fa-sort';
    }

    /**
     * @param $icon
     * @return string
     */
    private static function formTrailingTag($icon): string
    {
        $iconAndTextSeparator = '';
        return $iconAndTextSeparator.'<i class="'.$icon.'" style="margin-left: 7px"></i>'.'</a>';
    }
}
