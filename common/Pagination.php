<?php
declare(strict_types=1);

namespace app\common;

class Pagination {
    private $pagesNumber;

    public function setPagesNumber(int $pagesNumber)
    {
        $this->pagesNumber = $pagesNumber;
    }

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

    private function isFirst()
    {
        if (1 == $_GET['pagination'] || !isset($_GET['pagination'])) {
            return true;
        } else {
            return false;
        }
    }

    private function isLast()
    {}

    public function getPaginationHtml(array $pages, string $controller) : string
    {
        $html = "<nav aria-label=\"...\"><ul class=\"pagination\">";

        foreach ($pages as $page) {
            $class = $page['is_current'] ? ' class="active"' : '';
            $span = $page['is_current'] ? '<span class="sr-only">(current)</span>' : '';
            $url = Router::getUrl($controller, 'TaskList', ['pagination' => $page['number']]);
            $html .= "<li{$class}>
<a href=\"{$url}\">{$page['number']}{$span}</a>
</li>";
        }

        $html .= "</ul></nav>";

        return $html;
    }
}
