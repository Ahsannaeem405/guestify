<?php
class ScrapersShell extends Shell {

    /*
    public function __construct($stdout = null, $stderr = null, $stdin = null) {
        // This will cause all Shell outputs, eg. from $this->out(), to be written to
        // TMP.'shell.out'
        $stdout = new ConsoleOutput('file://'.TMP.'shell_scrapers.log');

        // You can do the same for stderr too if you wish
        // $stderr = new ConsoleOutput('file://'.TMP.'shell.err');

        parent::__construct($stdout, $stderr, $stdin);
    }
    *

    /**
    * scrape some restaurants to import for guestify
    * from the web-page "restaurant-kritik.de"
    *
    * @author digitalcube GmbH Co KG <dev@digital-cube.de>
    * @access public
    * @param void
    * @return void
    */
    public function restaurantkritik() {

        $date = date('Y-m-d H:i:s');

        $state_id = $this->args[0];

        if(!$state_id) {
            $this->out('please provide a state id!');
            exit(0);
        }

        # Configure::read not working from console, take arg to determine
        # the environment

        $this->out('starting scraper...');

        # shell configuration
        Configure::write('debug', 1);

        Configure::write('Cache.disable', true);
        Configure::write('Cache.check', false);

        // invoike app_controller
        App::uses('CakeRequest', 'Network');
        App::uses('CakeResponse', 'Network');
        App::uses('Controller', 'Controller');
        App::uses('AppController', 'Controller');


        // request/response may be optional, depends on your use
        $controller = new AppController(new CakeRequest(), new CakeResponse());
        $controller->constructClasses();
        $controller->startupProcess();

        # import HTML parse Vendor
        require_once(APP . 'Vendor/simple_html_dom.php');

        # holders
        $city_links = array();

        # main url definition
        $url_main = 'http://www.restaurant-kritik.de';
        
        # get the main landing page
        $links = array();
        $counter = 1;

        $handle = fopen(TMP . 'indexpages.txt', "r");
        if ($handle) {
            while(($line = fgets($handle)) !== false) {
                $temp = explode('|', $line);
                $links[$counter]['link'] = $temp[0];
                if(isset($temp[1]) && !empty($temp[1])) {
                    $links[$counter]['page_count'] = $temp[1];
                } else {
                    $links[$counter]['page_count'] = 1;
                }
                $counter++;
            }
        }
        fclose($handle);

        $links_by_state = array();
        for($i = 1; $i < 17; $i++) {
            $links_by_state[$i] = array();
        }

        foreach($links as $key => $link) {
            
            if(strpos($link['link'], 'Baden-W%C3%BCrttemberg') !== false) {
                array_push($links_by_state[1], $link);
            } elseif(strpos($link['link'], 'Bayern') !== false) {
                array_push($links_by_state[2], $link);
            } elseif(strpos($link['link'], 'Berlin') !== false) {
                array_push($links_by_state[3], $link);
            } elseif(strpos($link['link'], 'Brandenburg') !== false) {
                array_push($links_by_state[4], $link);
            } elseif(strpos($link['link'], 'Bremen') !== false) {
                array_push($links_by_state[5], $link);
            } elseif(strpos($link['link'], 'Hamburg') !== false) {
                array_push($links_by_state[6], $link);
            } elseif(strpos($link['link'], 'Hessen') !== false) {
                array_push($links_by_state[7], $link);
            } elseif(strpos($link['link'], 'Mecklenburg-Vorpommern') !== false) {
                array_push($links_by_state[8], $link);
            } elseif(strpos($link['link'], 'Niedersachsen') !== false) {
                array_push($links_by_state[9], $link);
            } elseif(strpos($link['link'], 'Nordrhein-Westfalen') !== false) {
                array_push($links_by_state[10], $link);
            } elseif(strpos($link['link'], 'Rheinland-Pfalz') !== false) {
                array_push($links_by_state[11], $link);
            } elseif(strpos($link['link'], 'Saarland') !== false) {
                array_push($links_by_state[12], $link);
            } elseif((strpos($link['link'], 'Sachsen') !== false) && (strpos($link['link'], 'Sachsen-Anhalt') === false)) {
                array_push($links_by_state[13], $link);
            } elseif(strpos($link['link'], 'Sachsen-Anhalt') !== false) {
                array_push($links_by_state[14], $link);
            } elseif(strpos($link['link'], 'Schleswig-Holstein') !== false) {
                array_push($links_by_state[15], $link);
            } elseif(strpos($link['link'], 'Thueringen') !== false) {
                array_push($links_by_state[16], $link);
            }
        }

        $Target = ClassRegistry::init('Target');

        $existing_entries = $Target->find('list', array(
            'conditions' => array(
                'Target.state_id' => $state_id
            ),
            'fields' => array(
                'Target.id',
                'Target.source_url'
            )
        ));

        $detail_links = array();

        #arsort($links_by_state[$state_id]);
        #pr($links_by_state[$state_id]);
        #exit;

        foreach($links_by_state[$state_id] as $key => $indexpage) {


            $this->out('---------------------');
            $this->out('scraping page: '.$indexpage['link']);

            #$url_index = 'http://www.restaurant-kritik.de/Deutschland/Nordrhein-Westfalen/k/koeln/die_besten_restaurants?page=';
            $url_index = $indexpage['link'];

            # use the limit option to define the number of list-pages
            $pages_limit = $indexpage['page_count'];

            # prepare the list of detail-page links
            for($i = 1; $i <= $pages_limit; $i++) {

                #$this->out('scraping page with index: '.$i);
                $this->out('scraping page index number: '.$i);

                #pr($url_index.$i);
                $aContext = array(
                    'http' => array(
                        'proxy' => 'tcp://218.92.227.171:33719',
                        'request_fulluri' => true,
                    ),
                );
                $cxContext = stream_context_create($aContext);

                /*
                if(!$str = file_get_html($url_index.$i, False, $cxContext)) {
                    pr('not working!');
                    continue;
                } else {
                    #pr('works!');
                    #exit;
                }
                */

                sleep(1);

                if(!$str = file_get_html($url_index.$i)) {
                    continue;
                }

                foreach($str->find('article[class="marker restaurant"]') as $result_container) {
                    
                    if(gettype($result_container->find('a[class="url fn org"]', 0)) != "NULL") {
                        
                        $dlink = $url_main.'/'.str_replace('/', '', trim($result_container->find('a[class="url fn org"]', 0)->href));

                        if(in_array($dlink, $existing_entries)) {
                            pr('skipping...');
                            continue;
                        }

                        sleep(1);

                        #$dlink = 'http://www.restaurant-kritik.de/55236';

                        $detail_links[] = $dlink;
                        $this->out('detailpage url found: '.$dlink);

                        $dpage = file_get_html($dlink);

                        $data = array();

                        # get the name of the restaurant
                        if(gettype($dpage->find('h1[class="item fn org name"]', 0)) != "NULL") {
                            $data['name'] = str_replace('&amp;', '&', trim($dpage->find('h1[class="item fn org name"]', 0)->plaintext));
                        } else {
                            $this->out('no-name hit!');
                            continue;
                        }

                        $data['scraper']     = 'restaurantkritik.de';
                        $data['source_url']  = $dlink;
                        $data['category_id'] = 1;
                        $data['state_id']    = $state_id;

                        # address
                        $data['address'] = '';
                        if(gettype($dpage->find('div[class="street"]', 0)) != "NULL") {
                            $data['address'] = trim($dpage->find('div[class="street"]', 0)->plaintext);
                        }

                        # location -> needs a splitting so we have the city AND the zipcode
                        $data['location'] = '';
                        if(gettype($dpage->find('div[class="location"]', 0)) != "NULL") {
                            
                            $data['location'] = trim($dpage->find('div[class="location"]', 0)->plaintext);
                            
                            $temp   = explode(",", $data['location']);
                            $temp2  = explode(" ", $temp[0]);
                            
                            $data['zipcode']    = $temp2[0];
                            $data['city']       = $temp2[1];
                            if(isset($temp[1])) {
                                $data['district']   = $temp[1];
                            } else {
                                $data['district'] = '';
                            }
                        }

                        # phone
                        $data['phone'] = '';
                        if(gettype($dpage->find('dd[class="phone"]', 0)) != "NULL") {
                            $data['phone'] = trim($dpage->find('dd[class="phone"]', 0)->plaintext);
                        }

                        # fax
                        
                        $data['fax'] = '';
                        if(gettype($dpage->find('dd[class="fax"]', 0)) != "NULL") {
                            $data['fax'] = trim($dpage->find('dd[class="fax"]', 0)->plaintext);
                        }

                        # web
                        foreach($dpage->find('dt') as $dt) {
                            if(gettype($dt) != "NULL") {
                                if($dt->plaintext == 'Web:') {
                                    $data['web'] = $dt->next_sibling('dd')->find('a', 0)->href;
                                }
                            }
                        }

                        $Target->create();
                        if(!$Target->save($data)) {
                            pr('saving of target failed!');
                            pr($Target->invalidFields());
                        }

                        $dpage->clear();
                    }
                }

                $str->clear();
            }


            $this->out('---------------------');
        }


        # tmp writing to file 
        $file = TMP . 'detailpages_'.$state_id.'.txt';
        $string = '';
        foreach($detail_links as $key => $detail_link) {
            $string .= $detail_link."\n";
        }
        file_put_contents($file, $string);
        exit(0);
    }

}
