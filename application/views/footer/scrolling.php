<?php

        if (isset( $_SERVER['HTTP_REFERER'])) {
            $termek = $this->uri->segment(1) . '/' . $this->uri->segment(2);
            $referer_parts = explode('/', $_SERVER['HTTP_REFERER']);
            
            if (array_key_exists(4, $referer_parts))
                $referer_termek = 'termekek/'.$referer_parts[4];
            

            
                if ($_SERVER['HTTP_REFERER'] == "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") {
                    $scroll_top = $this->input->cookie('last_scroll');   

                            echo "
                            <script>
                            $(window).scrollTop('".$scroll_top."');
                            </script>
                            ";

                }

                else if (isset($referer_termek) AND $referer_termek == $termek) {
                    $scroll_top = $this->input->cookie('last_scroll');   
                    
                            echo "
                            <script>
                            $(window).scrollTop('".$scroll_top."');
                            </script>
                            ";

                }
                else if ($_SERVER['HTTP_REFERER'] !=  "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") {
                        delete_cookie('last_scroll');
                    }
        }
            


