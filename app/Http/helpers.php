<?php
/*
function view($view = null, $data = [], $mergeData = [])
{
    $factory = app('Illuminate\Contracts\View\Factory');

    // if no argument is passed it returns the view factory
    if (func_num_args() === 0) {
        return $factory;
    }

    // check if view is already a mobile view
    $is_mobile_view = substr($view, -7) == '.mobile';

    // if mobile agent and not mobile view, get the mobile view
    if(Agent::isMobile() && !$is_mobile_view)
    {
        $view .= '.mobile';
    }

    return $factory->make($view, $data, $mergeData);
}
*/


/**
 * Render a basic template
 *
 * @param $title
 * @param $content
 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
 */
function basic($title, $content) {
    return view('basic', ['title' => $title, 'content' => $content]);
}

/**
 * Send slack message
 *
 * @param $message
 * @return \Models\Slack
 */
function slack($message = null) {

    /**@var \Models\Slack $slack*/
    $slack = app()->make('maknz.slack');

    if (!is_null($message)) {
        $slack->setText($message);
    }

    return $slack;
}

/**
 *
 *
 * @param $method
 * @param array $parameters
 * @param null $host
 * @return string
 */
function get($method, $parameters = [], $host = null) {

    $url = (is_null($host) ? '' : $host) . $method;

    // gestion des paramètre
    if (!empty($parameters) ) {

        // ajout du ? si pas de paramètre get dans l'ural de base
        if (strpos($url, '?') === false) {
            $url .= '?';
        }

        // ajout des paramètre
        $url .= '&' . http_build_query($parameters);
    }

    return $url;
}

/**
 * Met en avant les
 *
 * @param $string
 * @return mixed
 */
function url_highlight($string) {


    $matches = [];
    if (preg_match_all('#https?:[^\s]+#', $string, $matches)) {
        foreach($matches[0] as $url) {
            $string = str_replace($url, html('a', ['target' => '_blank', 'href' => $url], $url), $string);
        }
    }

    return $string;
}



/**
 * Extract meta data from url
 *
 * @param $url
 * @return array
 */
function extract_meta_url($url) {

    $data = [];
    try {
        $client = new \GuzzleHttp\Client();
        $res = $client->get($url);

        if ($res->getStatusCode() == 200) {
            $content = $res->getBody()->getContents();
            $data = [];

            // charset detection
            if (preg_match('#<meta.+charset=(?<charset>[\w\-]+).+/?>#', $content, $match)
                || preg_match('#<meta.+charset="(?<charset>[^"]+)"#', $content, $match)) {
                $charset = strtolower($match['charset']);
                if ($charset == 'utf-8') {
                    $content = utf8_decode($content);
                }
            }

            // titre
            if (preg_match('#<title>(?<title>.+)</title>#', $content, $match)) {

                $title = '';
                foreach(str_split($match['title']) as $c) {
                    $title .= ffunichr(ord($c));
                }

                $data['source_title'] = html_entity_decode($title);

                $emoticon = [';)', ':)', ':p',  '=D', 'B|'];

                // hack formatage title HDN
                $data['source_title'] = str_replace('– HDN – Histoires du net', ' ' . $emoticon[array_rand($emoticon)], $data['source_title'] );
            }

            // other meta
            if (preg_match_all('#<meta[^>]+/?>#s', $content, $matches)) {

                foreach($matches[0] as $meta) {

                    if (preg_match('#property=.og:description.#', $meta)) {
                        if (preg_match('#content="(?<description>[^"]+)"#s', $meta, $match)) {
                            $description = '';
                            foreach(str_split($match['description']) as $c) {
                                $description .= ffunichr(ord($c));
                            }
                            $data['source_description'] = html_entity_decode($description);
                        }
                    } elseif (preg_match('#property=.og:image[^:]#', $meta)) {
                        if (preg_match('#content="(?<image>[^"]+)"#', $meta, $match)) {

                            $image = '';
                            foreach(str_split($match['image']) as $c) {
                                $image .= ffunichr(ord($c));
                            }

                            $data['source_media'] = $image;

                        }
                    } elseif (empty($data['source_description']) && preg_match('#name=.description.#', $meta)) {
                        if (preg_match('#content="(?<description>[^"]+)"#s', $meta, $match)) {
                            $description = '';
                            foreach(str_split($match['description']) as $c) {
                                $description .= ffunichr(ord($c));
                            }
                            $data['source_description'] = html_entity_decode($description);
                        }
                    }
                }
            }
        }
    } catch (\Exception $e) {}

    return $data;
}


