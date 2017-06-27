<?php
declare(strict_types=1);

namespace app\common;

/**
 * Класс для работы с пагинацией
 *
 * Class Pagination
 * @package app\common
 */
class Pagination {
    private $pagesNumber;

    /**
     * Сеттер для количества страниц
     * @param int $pagesNumber
     */
    public function setPagesNumber(int $pagesNumber)
    {
        $this->pagesNumber = $pagesNumber;
    }

    /**
     * Возвращает массив описывающий ссылки для пагинации
     *
     * @return array
     */
    public function getPages() : array
    {
        $pagination = isset($_GET['pagination']) ? $_GET['pagination'] : 1;
        $pages = [];
        for ($page = 1; $page <= $this->pagesNumber; $page++) {
            $pages[] = [
                'number' => $page,
                'is_current' => $page == $pagination ? true : false,
            ];
        }
        return $pages;
    }

    /**
     * Генерация html кода для ссылок пагинации
     *
     * @param array $pages массив описывающий ссылки для пагинации
     * @param string $controller указание на контроллер для которого требуется пагинация
     * @return string html код ссылок пагинации
     */
    public function getPaginationHtml(array $pages, string $controller) : string
    {
        $html = "<nav aria-label=\"...\"><ul class=\"pagination\">";

        foreach ($pages as $page) {

            $urlParams = ['pagination' => $page['number']];
            if (isset($_GET['user_name']) && $_GET['user_name'] != '') {
                $urlParams['user_name'] = $_GET['user_name'];
            }
            if (isset($_GET['email']) && $_GET['email'] != '') {
                $urlParams['email'] = $_GET['email'];
            }
            if (isset($_GET['status']) && $_GET['status'] != '0') {
                $urlParams['status'] = $_GET['status'];
            }

            $class = $page['is_current'] ? ' class="active"' : '';
            $span = $page['is_current'] ? '<span class="sr-only">(current)</span>' : '';
            $url = Router::getUrl($controller, 'TaskList', $urlParams);
            $html .= "<li{$class}>
<a href=\"{$url}\">{$page['number']}{$span}</a>
</li>";
        }

        $html .= "</ul></nav>";

        return $html;
    }
}
