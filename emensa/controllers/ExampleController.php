<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/kategorie.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/emensa/models/gericht.php');

class ExampleController
{
    public function m4_6a_queryparameter(RequestData $rd) {
        /*
           Wenn Sie hier landen:
           bearbeiten Sie diese Action,
           so dass Sie die Aufgabe löst
        */

        return view('notimplemented', [
            'request'=>$rd,
            'url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"
        ]);
    }


    public function m4_7a_queryparameter($request)
    {
        $name = isset($_GET['name']) ? $_GET['name'] : 'default';
        return view('examples.m4_7a_queryparameter', ['name' => $name]);
    }


   public function  m4_7b_kategorie(){
         $data = db_select_Kategorie_Gericht();
          return view('examples.m4_7b_kategorie', ['data' => $data]);
   }


   public function m4_7c_gerichte(){

          $data = db_select_gericht_preis_intern();
          return view('examples.m4_7c_gerichte', ['data'=>$data]);

   }

   public  function m4_7d_page ($request){

        if(isset($_GET['no'])){
            if($_GET['no'] == 1)
            return view('examples.pages.m4_7d_page_1');
            elseif ($_GET['no']==2){
                return view('examples.pages.m4_7d_page_2');
            }

        }
        else{
            return view('examples.pages.m4_7d_page_1');
        }
       return view('examples.pages.m4_7d_page_1');
   }


}

