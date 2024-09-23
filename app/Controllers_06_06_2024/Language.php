<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Language extends BaseController
{
    public function index()
    {
        $session = session();
        $locale = $this->request->getLocale();
        $session->remove('lang');
        $session->set('lang', $locale);
        $url = previous_url();

        # Set Language Name
        if($locale == "en") {
            $language = "English";
        } else if ($locale == "ro") {
            $language = "Română";
        } else if ($locale == "hu") {
            $language = "Maghiară";
        }

        

        $session->set('language', $language);

        return redirect()->to($url);
    }
}