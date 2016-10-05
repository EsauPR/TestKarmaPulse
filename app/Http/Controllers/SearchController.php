<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Search;
use App\Models\Tweet;
use \DateTime;

class SearchController extends Controller
{
    /**
     * Muestra la vista
     *
     * @return \Illuminate\Http\Response
     */
    public function index($result = null, $query = null)
    {
        return view('welcome')
            ->with('searches', Search::all())
            ->with('result', $result)
            ->with('query', $query);
    }

    /**
     * Procesa la solicitud
     * @param  \Illuminate\Http\Request $request
     * @param  string  $f       [description]
     * @return \Illuminate\Http\Response
     */
    public function preprocess(Request $request, $f )
    {
        return $this->index(
            $this->$f(
                $request->input('searchId'),
                new DateTime($request->input('initialDate')),
                new DateTime($request->input('finalDate'))
            ),
            [
                'Función' => $f,
                'searchID' => $request->input('searchId'),
                'Fecha inicial' => $request->input('initialDate'),
                'Fecha final' => $request->input('finalDate'),
            ]
        );
    }

    /**
     * Devuelve el número de tweets, numero total de usuarios únicos, menciones únicas y hashtags únicos de toda la búsqueda.
     *
     * @param  string $searchId
     * @param  date $finalDate
     * @param  date $initialDate
     * @return \Illuminate\Http\Response
     */
    public function f1($searchId, $initialDate, $finalDate)
    {
        $search = Search::find($searchId);
        $tweets = $search->tweets()
            ->where('postedTime', '>=', $initialDate)
            ->where('postedTime', '<=', $finalDate)
            ->get();

        $result['No. de Tweets'] = count($tweets);
        $result['No. de Usuarios únicos'] = count($this->uniqueUsers($tweets));
        $result['Menciones únicas'] = $this->uniqueMentions($tweets);
        $result['Hashtags únicos'] = $this->uniqueHashtags($tweets);

        return $result;
    }

    /**
     * Top 10 de los hashtags con mayores apariciones en la búsqueda.
     * @param  string $searchId
     * @param  date $initialDate
     * @param  date $finalDate
     * @return \Illuminate\Http\Response
     */
    public function f2($searchId, $initialDate, $finalDate)
    {
        $search = Search::find($searchId);
        $tweets = $search->tweets()
            ->where('postedTime', '>=', $initialDate)
            ->where('postedTime', '<=', $finalDate)
            ->get();

        return ['Top 10 Hashtag' => array_slice($this->topHashtags($tweets), 0 , 10)];
    }

    /**
     * Porcentaje de retweets y tweets originales.
     * @param  string $searchId
     * @param  date $initialDate
     * @param  date $finalDate
     * @return \Illuminate\Http\Response
     */
    public function f3($searchId, $initialDate, $finalDate)
    {
        $search = Search::find($searchId);
        $tweets = $search->tweets()
            ->where('postedTime', '>=', $initialDate)
            ->where('postedTime', '<=', $finalDate)
            ->get();

        $nTweets = 0;
        $nRetweets = 0;

        $total = 0;
        foreach ($tweets as $tweet) {
            $total +=1;
            if ($tweet->verb == 'post') {
                $nTweets += 1;
            } elseif ( $tweet->verb == 'share' ) {
                $nRetweets += 1;
            }
        }

        return [
            'Tweets' => ($total !=0 )?($nTweets / $total).'%':'0.0%',
            'Retweets' => ($total !=0 )?($nRetweets / $total)."%":'0.0%',
        ];
    }

    /**
     * Retorna las menciones de los tweets sin repetir
     * @param  array $tweets
     * @return array
     */
    private function uniqueMentions($tweets)
    {
        $mentions = array();

        foreach ($tweets as $tweet) {
            foreach ($tweet->menciones as $mention) {
                array_push($mentions, $mention);
            }
        }

        $mentions = array_unique($mentions);
        asort($mentions);

        return array_values($mentions);
    }

    /**
     * Retorna los hashtags ordenados por número de apariciones
     * @param  array $tweets
     * @return array
     */
    private function topHashtags($tweets)
    {
        $hashtags_top = array();

        foreach ($tweets as $tweet) {
            foreach ($tweet->hashtags as $hashtag) {
                $value = strtolower($hashtag);
                $hashtags_top[$value]  = isset($hashtags_top[$value])? $hashtags_top[$value]+1:1;
            }
        }

        arsort($hashtags_top);

        return $hashtags_top;
    }

    /**
     * Retorna los hashtags de los tweets sin repetir
     * @param  array $tweets
     * @return array
     */
    private function uniqueHashtags($tweets)
    {
        $hashtags = array();

        foreach ($tweets as $tweet) {
            foreach ($tweet->hashtags as $hashtag) {
                array_push($hashtags, strtolower($hashtag));
            }
        }

        $hashtags = array_unique($hashtags);
        asort($hashtags);

        return array_values($hashtags);
    }

    /**
     * Retorna los de usuarios no repetidos
     * @param  array $tweets
     * @return array
     */
    private function uniqueUsers($tweets){
        $users = array();

        foreach ($tweets as $tweet) {
            array_push($users, $tweet->usuario['preferredUsername']);
        }

        return array_values(array_unique($users));
    }
}
