<?php
/**
 * Created by PhpStorm.
 * User: Aleksey
 * Date: 14/12/16
 * Time: 1:12 PM
 * Email: <Portnov21@gmail.com>
 */

namespace app;

use Curl;
use models\Films;
use models\Genre;
use models\Images;
use models\People;
use models\Rel_genre;
use models\Rel_people;
use pattern\Hdkinohit_pattern;
use PDO;


/**
 * Class Hdkinohit
 * @package app
 */
class Hdkinohit extends Hdkinohit_pattern
{
    const HOST = 'hdkinohit.net';
    const RSS = 'http://' . self::HOST . '/rss.xml';

    /* @var string */
    protected $html = '';

    public function start()
    {
        $url = 'http://' . self::HOST . '/page/';
        for ($i = 302; $i > 0; $i--) {
            echo 'page: ' . $i . "\n";
            $links = $this->getLinks($this->getData($url . $i));
            $this->save($links);
        }

//        if ($links = $this->getLinksRss($this->getData(self::RSS)))
//            $this->save($links, $model);

    }

    private function save(array $links = [])
    {
        foreach ($links as $link) {
            $this->html = $this->getData($link);
            $title_hash = md5($this->getTitle());

            if (empty($this->getVideoId()) || Films::hasTitle($title_hash))
                continue;

            $imageId = Images::save(['alias' => $this->getImage()]);

            $filmId = Films::save([
                'title' => $this->getTitle(),
                'title_hash' => $title_hash,
                'description' => $this->getDescription(),
                'link_video' => $this->getVideoId(),
                'year' => $this->getYear(),
                'provider' => self::HOST,
                'url' => $link,
                'rips' => $this->getRips(),
                'title_trans' => $this->getTransName($link),
                'image_id' => $imageId
            ]);

            foreach ($this->getPeople() as $person) {
                if (!empty($people = People::findAll(['name' => trim($person)])->fetch(PDO::FETCH_ASSOC))) {
                    $peopleId = $people['id'];
                } else {
                    $peopleId = People::save(['name' => trim($person)]);
                }

                Rel_people::save([
                    'film_id' => $filmId,
                    'people_id' => $peopleId
                ]);
            }

            foreach ($this->getGenre() as $genre) {
                if (!empty($findGenre = Genre::findAll(['name' => trim($genre)])->fetch(PDO::FETCH_ASSOC))) {
                    $genreId = $findGenre['id'];
                } else {
                    $genreId = Genre::save(['name' => trim($genre)]);
                }

                Rel_genre::save([
                    'genre_id' => $genreId,
                    'film_id' => $filmId
                ]);
            }
        }


    }

    /**
     * @param $url
     * @return string
     */
    private function getData($url)
    {
        $curl = new Curl();
        $curl->url = $url;

        return iconv("windows-1251", "utf-8", $curl->getData());
    }


}