<?php

namespace App\Helpers;

use JetBrains\PhpStorm\ArrayShape;

class PaginationHelper
{
    protected int $take = 20;
    protected int $page = 1;

    public function __construct()
    {
        if (request()->has('take')) {
            $this->take = (int)request()->input('take');
        }
        if (request()->has('page')) {
            $this->page = (int)request()->input('page');
        }
    }

    #[ArrayShape(['take'  => "int",
                  'page'  => "int",
                  'pages' => "float|int"
    ])] public function count(int $count): array
    {
        $data = [
            'take' => $this->take,
            'page' => $this->page,
            'pages' => 1
        ];
        $pages = 0;
        if ($this->take < $count) {
            $pages = floor(($count / $this->take));
            if (($count % $this->take) > 0) {
                $pages++;
            }
        }
        if ($pages > 0) {
            $data['pages'] = $pages;
        }
        return $data;
    }
}