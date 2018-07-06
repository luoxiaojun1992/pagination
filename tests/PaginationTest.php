<?php

/**
 * Class PaginationTest
 *
 * {@inheritdoc}
 *
 * Lightweight Pagination Unit Test
 */
class PaginationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test Calculate pagination params
     */
    public function testCalculate()
    {
        //case1

        //请求参数
        $total = 100;
        $page_num = 1;
        $per_page = 10;

        //期望输出
        $page_total = 10;
        $offset = 0;

        $pagination = new \Lxj\Pagination\Pagination($total, $per_page, $page_num);

        //校验输出
        $this->assertEquals($page_total, $pagination->getPageTotal());
        $this->assertEquals($offset, $pagination->getOffset());

        //case2

        //请求参数
        $total = 100;
        $page_num = 2;
        $per_page = 10;

        //期望输出
        $page_total = 10;
        $offset = 10;

        $pagination = new \Lxj\Pagination\Pagination($total, $per_page, $page_num);

        //校验输出
        $this->assertEquals($page_total, $pagination->getPageTotal());
        $this->assertEquals($offset, $pagination->getOffset());

        //case3

        //请求参数
        $total = 101;
        $page_num = 2;
        $per_page = 10;

        //期望输出
        $page_total = 11;
        $offset = 10;

        $pagination = new \Lxj\Pagination\Pagination($total, $per_page, $page_num);

        //校验输出
        $this->assertEquals($page_total, $pagination->getPageTotal());
        $this->assertEquals($offset, $pagination->getOffset());
    }

    /**
     * Test Fix pagination params
     */
    public function testFix()
    {
        //case1

        //请求参数
        $total = 101;
        $page_num = 2;
        $per_page = 10;

        $pagination = new \Lxj\Pagination\Pagination($total, $per_page, $page_num);

        //期望输出
        $page_total = 2;
        $total = 15;

        $pagination->fix(5);

        //校验输出
        $this->assertEquals($page_total, $pagination->getPageTotal());
        $this->assertEquals($total, $pagination->getTotal());

        //case2

        //请求参数
        $total = 101;
        $page_num = 12;
        $per_page = 10;

        $pagination = new \Lxj\Pagination\Pagination($total, $per_page, $page_num);

        //期望输出
        $page_total = 12;
        $total = 115;

        $pagination->fix(5);

        //校验输出
        $this->assertEquals($page_total, $pagination->getPageTotal());
        $this->assertEquals($total, $pagination->getTotal());

        //case3

        //请求参数
        $total = 101;
        $page_num = 12;
        $per_page = 10;

        $pagination = new \Lxj\Pagination\Pagination($total, $per_page, $page_num);

        //期望输出
        $page_total = 11;
        $total = 101;

        $pagination->fix(0);

        //校验输出
        $this->assertEquals($page_total, $pagination->getPageTotal());
        $this->assertEquals($total, $pagination->getTotal());
    }

    /**
     * Test Render pagination ui
     */
    public function testRender()
    {
        //case1

        //请求参数
        $total = 100;
        $page_num = 1;
        $per_page = 10;
        $render = function ($total, $per_page, $page_num, $page_total, $next_page, $prev_page) {
            return compact('total', 'per_page', 'page_num', 'page_total', 'next_page', 'prev_page');
        };

        //期望输出
        $result = [
            'total' => $total,
            'per_page' => $per_page,
            'page_num' => $page_num,
            'page_total' => 10,
            'next_page' => 2,
            'prev_page' => 1,
        ];

        $pagination = new \Lxj\Pagination\Pagination($total, $per_page, $page_num, $render);

        //校验输出
        $this->assertEquals($result, $pagination->render());

        //case1

        //请求参数
        $total = 100;
        $page_num = 10;
        $per_page = 10;
        $render = function ($total, $per_page, $page_num, $page_total, $next_page, $prev_page) {
            return compact('total', 'per_page', 'page_num', 'page_total', 'next_page', 'prev_page');
        };

        //期望输出
        $result = [
            'total' => $total,
            'per_page' => $per_page,
            'page_num' => $page_num,
            'page_total' => 10,
            'next_page' => 10,
            'prev_page' => 9,
        ];

        $pagination = new \Lxj\Pagination\Pagination($total, $per_page, $page_num, $render);

        //校验输出
        $this->assertEquals($result, $pagination->render());
    }
}
