<?php

class hydrate
{

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            $key = explode("_", $key, 2);
            if(sizeof($key) > 1)
                $method = 'set'. $key[0] . $key[1];
            else
                $method = 'set'. $key[0];
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }

}