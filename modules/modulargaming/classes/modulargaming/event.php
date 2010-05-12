        public static function sidebar_right()
        {
                $s = Event::$data;

                if ( ! $s->user)
                {
                        return false;
                }

                Character_Event::load_character($s);

                $s->sidebar_right[] = View::factory('character/sidebar')
                                ->set('character', $s->character)
                                ->set('char', new Character($s->character));


        }

