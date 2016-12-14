<?php
/**
 * Created by PhpStorm.
 * User: Aleksey
 * Date: 14/12/16
 * Time: 1:12 PM
 * Email: <Portnov21@gmail.com>
 */

namespace template;

use Curl;
use models\Model;

/**
 * Class Hdkinohit
 * @package template
 */
class Hdkinohit
{
    /**
     *
     */
    const HOST = 'hdkinohit.net';

    /**
     * @var string
     */
    private $html = '';

    /**
     *
     */
    public function start()
    {
        $model = new Model();
        $url = 'http://' . self::HOST . '/page/';
        for ($i = 0; $i < 301; $i++) {
            echo 'page: ' . $i . "\n";
            $html = $this->getHtml($url . $i);
            $links = $this->getLinks($html);
            $arr = [];
            foreach ($links as $link) {
                $this->html = $this->getHtml($link);

                if (empty($this->getVideoId()))
                    continue;

                $arr['title'] = $this->getTitle();
                $arr['title_hash'] = md5($this->getTitle());
                $arr['description'] = $this->getDescription();
                $arr['link_video'] = $this->getVideoId();
                $arr['year'] = $this->getYear();
                $arr['site'] = self::HOST;
                $arr['url'] = $link;

                $model->table = 'images';
                $arr['image_id'] = $model->insert(['alias' => $this->getImage()]);

                $model->table = 'films';
                $filmId = $model->insert($arr);

                $model->table = 'people';
                foreach ($this->getPeople() as $person)
                    $model->insert([
                        'name' => trim($person),
                        'film_id' => $filmId
                    ]);

                $model->table = 'genre';
                foreach ($this->getGenre() as $genre)
                    $filmId = $model->insert([
                        'name' => trim($genre),
                        'film_id' => $filmId
                    ]);

            }
        }
    }

    /**
     * @param $html
     * @return array
     */
    private function getLinks($html)
    {
        if (preg_match_all('/"><a href="(?<links>http:.*html)"><span class="fbutton-img">/', $html, $matches))
            return $matches['links'];

        return [];
    }


    /**
     * @param $url
     * @return string
     */
    private function getHtml($url)
    {
        $curl = new Curl();
        $curl->url = $url;

        return iconv("windows-1251", "utf-8", $curl->getHtml());
    }

    /**
     * @return string
     */
    private function getVideoId()
    {
        if (preg_match('/stream\/(?<id>\d+)"/', $this->html, $matches))
            return $matches['id'];

        return '';
    }

    /**
     * @return string
     */
    private function getTitle()
    {
        if (preg_match('/<meta property="og:title" content="(?<title>.*)\(/', $this->html, $matches))
            return $matches['title'];

        return '';
    }

    /**
     * @return string
     */
    private function getYear()
    {
        if (preg_match('/<meta property="og:title" content=".*\((?<year>\d+)\)/', $this->html, $matches))
            return $matches['year'];

        return '';
    }

    /**
     * @return string
     */
    private function getDescription()
    {
        if (preg_match('/"><\/span>(?<description>.*)<br><br>/', $this->html, $matches))
            return $film['description'] = $matches['description'];

        return '';
    }

    /**
     * @return string
     */
    private function getImage()
    {
        if (preg_match('/<div class="fullimg"><img src="(?<image>.*)"\sstyle/', $this->html, $matches))
            return $matches['image'];

        return '';
    }

    /**
     * @return array
     */
    private function getPeople()
    {
        if (preg_match('/ролях:<\/span> <span class="lbl_ful_2">(?<people>.*)<\/span>/', $this->html, $matches))
            return explode(',', $matches['people']);

        return [];
    }

    /**
     * @return array
     */
    private function getGenre()
    {
        if (preg_match('/Жанр:<\/span> <span class="lbl_ful_2">(?<genre>.*)<\/span>/', $this->html, $matches))
            return explode('/', $matches['genre']);

        return [];
    }


}