<?php
/**
 * Created by PhpStorm.
 * User: Annatar
 * Date: 2015/10/6
 * Time: 15:07
 */

namespace Annatar\Curl\Analysis;
use Annatar\TheInterfaces\AnalysisInterface;
use Annatar\Curl\CrawlerTraits\AddUsersTrait;

class UserFollowersAnalysis implements AnalysisInterface
{
    use AddUsersTrait;

    private $data = '';

    private $afterAnalysis = [];


    /**
     * 分析数据，获取关注者并返回
     *
     * @param $data
     * @return array
     */
    public function analysis($data) {

        $this->data = $data;

        $this->getFollowers();
        return $this->afterAnalysis;
    }

    /**
     * 获取关注者
     *
     * （命名好像乱了）囧
     *
     * @return array
     */
    protected function getFollowers() {

        $tmp_after_analysis = [];
        preg_match_all($this->usersRegx['followers'], $this->data, $followers);

        array_shift($followers);

        array_map(function($n) use (&$tmp_after_analysis) {

            array_push($tmp_after_analysis, $n);
        }, $followers);

        return $this->extra($tmp_after_analysis);

    }

    /**
     * 把二维数组转成一维数组
     * @param array $data
     * @return array
     */
    protected function extra(array $data) {
        foreach($data[0] as $v) {
            $this->afterAnalysis[] = $v;
        }

        return $this->afterAnalysis;
    }
}