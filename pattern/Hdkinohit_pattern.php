<?php
/**
 * Created by PhpStorm.
 * User: Aleksey
 * Date: 14/12/16
 * Time: 1:12 PM
 * Email: <Portnov21@gmail.com>
 */

namespace pattern;


/**
 * Class Hdkinohit_pattern
 * @package pattern
 */
class Hdkinohit_pattern
{

    /* @var string */
    protected $html = '';

    /**
     * @param $html
     * @return array
     */
    protected function getLinks($html)
    {
        if (preg_match_all('/"><a href="(?<links>http:.*html)"><span class="fbutton-img">/', $html, $matches))
            return $matches['links'];

        return [];
    }

    /**
     * @return string
     */
    protected function getVideoId()
    {
        if (preg_match('/stream\/(?<id>\d+)"/', $this->html, $matches))
            return $matches['id'];

        return '';
    }

    /**
     * @return string
     */
    protected function getTitle()
    {
        if (preg_match('/<meta property="og:title" content="(?<title>.*)\(/', $this->html, $matches))
            return $matches['title'];

        return '';
    }

    /* @return string */
    protected function getYear()
    {
        if (preg_match('/<meta property="og:title" content=".*\((?<year>\d+)\)/', $this->html, $matches))
            return $matches['year'];

        return '';
    }

    /* @return string */
    protected function getDescription()
    {
        if (preg_match('/"><\/span>(?<description>.*)<br><br>/', $this->html, $matches))
            return $film['description'] = $matches['description'];

        return '';
    }

    /* @return string */
    protected function getImage()
    {
        if (preg_match('/<div class="fullimg"><img src="(?<image>.*)"\sstyle/', $this->html, $matches))
            return $matches['image'];

        return '';
    }

    /* @return array */
    protected function getPeople()
    {
        if (preg_match('/ролях:<\/span> <span class="lbl_ful_2">(?<people>.*)<\/span>/', $this->html, $matches))
            return explode(',', $matches['people']);

        return [];
    }

    /* @return array */
    protected function getGenre()
    {
        if (preg_match('/Жанр:<\/span> <span class="lbl_ful_2">(?<genre>.*)<\/span>/', $this->html, $matches))
            return explode('/', $matches['genre']);

        return [];
    }

    /* @return string */
    protected function getRips()
    {
        if (preg_match('/<div class="hdkh".*>(?<rips>.*)<\/div>/u', $this->html, $matches))
            return $matches['rips'];

        return '';
    }

    /**
     * @param $link
     * @return string
     */
    protected function getTransName($link)
    {
        if (preg_match('/\/[\d]+-(?<trans_name>.*)-[\d]{4}\.html/', $link, $matches))
            return $matches['trans_name'];

        return '';
    }

    /**
     * @param $xml
     * @return array
     */
    protected function getLinksRss($xml)
    {
        if (preg_match_all('/(?<links>http:\/\/hdkinohit.net\/filmi\d{4}\/.+\.html)/', $xml, $matches))
            return $matches['links'];

        return [];
    }


}