

<?php
    /* THIS CLASS GETS THE URL AND REDIRECTS TO SPECIFIC PAGE */
     class Core
    {
        protected $currentController = 'Pages';
        protected $currentMethod ='index';
        protected $params =[];

        /*constructor*/
        public function __construct()
        {
            //if page exists then set it current page//
            $url = $this->getUrl();
            if(!empty($url[0]))
            {
              if(file_exists( '../app/controllers/'.ucwords($url[0]).'.php'))
                 {
                    $this->currentController = ucwords($url[0]) ;
                    unset($url[0]);
                   //echo 'inside';
                   
                   
                   //
                 } 
                 
                 
             }
             require_once '../app/controllers/'.$this->currentController.'.php';
             $this->currentController  = new $this->currentController; 
             

             /*check method exist in controller)*/
             if(!empty($url[1]))
            {
                 if(isset($url[1]))
                 {
                    if(method_exists( $this->currentController,ucwords($url[1])))
                     {
                        $this->currentMethod =  ucwords($url[1]);
                        //echo  $this->currentMethod;

                    }
                    
                 }    
                 else
                    {
                        //require_once '../app/Bootstrap.php';
                    }
                    unset($url[1]);

            }
             /*passing values to method in controller*/

            
             $this->params = $url ? array_values($url) :[] ;
             call_user_func_array([$this->currentController ,$this->currentMethod],$this->params);
             
        }

      


        public function getUrl()
        {
            $url='';
          if(isset($_GET['url']))
          {
            //$url ? array_values($url) :[] ;
              $url = rtrim($_GET['url'] ,'/');
              $url = filter_var($url,FILTER_SANITIZE_URL);
              $url = explode('/',$url);
              return $url;
          }
        }
    }



?>