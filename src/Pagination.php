<?php

namespace Lxj\Pagination;

/**
 * Class Pagination
 *
 * {@inheritdoc}
 *
 * Lightweight Pagination
 *
 * @package Lxj\Pagination
 */
class Pagination
{
    private $total;

    private $per_page;

    private $page_num = 1;

    private $offset;

    private $page_total;

    /**
     * @var callable|null $render
     */
    private $render;

    public function __construct($total, $per_page, $page_num = 1, ?callable $render = null)
    {
        $this->total = $total;
        $this->per_page = $per_page;
        $this->page_num = $page_num;
        $this->render = $render;

        $this->calculate();
    }

    /**
     * Calculate pagination params
     */
    private function calculate()
    {
        $this->page_total = intval(ceil($this->total / $this->per_page));
        $this->offset = ($this->page_num - 1) * $this->per_page;
    }

    /**
     * Fix pagination params
     *
     * @param  $current_page_count
     * @return $this
     */
    public function fix(int $current_page_count): self
    {
        $current_total = ($this->page_num - 1) * $this->per_page + $current_page_count;
        if ($current_total > $this->total) {
            if ($current_page_count > 0) {
                $this->total = $current_total;
                $this->calculate();
            }
        } elseif ($current_total < $this->total) {
            if ($current_page_count < $this->per_page) {
                $this->total = $current_total;
                $this->calculate();
            }
        }
        return $this;
    }

    /**
     * @param int $total
     * @return $this
     */
    public function setTotal(int $total): self
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return mixed
     */
    public function getPerPage(): int
    {
        return $this->per_page;
    }

    /**
     * @return int
     */
    public function getPageNum(): int
    {
        return $this->page_num;
    }

    /**
     * @return mixed
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return mixed
     */
    public function getPageTotal(): int
    {
        return $this->page_total;
    }

    /**
     * Render pagination ui
     *
     * @return mixed|null
     */
    public function render()
    {
        if (!is_null($this->render)) {
            return call_user_func_array($this->render, [
                'total' => $this->total,
                'per_page' => $this->per_page,
                'page_num' => $this->page_num,
                'page_total' => $this->page_total,
                'next_page' => $this->page_num < $this->page_total ? $this->page_num + 1 : $this->page_total,
                'prev_page' => $this->page_num > 1 ? $this->page_num - 1 : 1
            ]);
        }

        return null;
    }
}
