<?php
class Formulaire{

	private $method;
	private $action;
	private $nom;
	private $style;

	private $ligneComposants = array();
	private $tabComposants = array();

	public function __construct($uneMethode, $uneAction , $unNom,$unStyle ){
		$this->method = $uneMethode;
		$this->action =$uneAction;
		$this->nom = $unNom;
		$this->style = $unStyle;
	}


	public function concactComposants($unComposant , $autreComposant ){
		$unComposant .=  $autreComposant;
		return $unComposant ;
	}

	public function ajouterComposantLigne($unComposant){
		$this->ligneComposants[] = $unComposant;
	}

	public function ajouterComposantTab(){
		$this->tabComposants[] = $this->ligneComposants;
		$this->ligneComposants = array();
	}

	public function creerLabel($unLabel){
		$composant = "<label>" . $unLabel . "</label>";
		return $composant;
	}

    public function creerLabelId($unLabel, $unId){
        $composant = "<label id='". $unId ."'>" . $unLabel . "</label>";
        return $composant;
    }

	public function creerInputTexte($unNom, $unId, $uneValue , $required , $placeholder , $pattern){
		$composant = "<input type = 'text' class='form-control' name = '" . $unNom . "' id = '" . $unId . "' ";
		if (!empty($uneValue)){
			$composant .= "value = '" . $uneValue . "' ";
		}
		if (!empty($placeholder)){
			$composant .= "placeholder = '" . $placeholder . "' ";
		}
		if ($required == 1){
			$composant .= "required ";
		}
		if (!empty($pattern)){
			$composant .= "pattern = '" . $pattern . "' ";
		}
		$composant .= "/>";
		return $composant;
	}

	public function creerInputSearch($unNom, $unId, $uneValue , $required , $placeholder , $pattern, $btnClass = "light", $btnText){
	    $composant = "<div style='margin-bottom : 10px; margin-top: 40px;' class=\"form-row align-items-center\"><div class='input-group col-md-4 mb-4'>";
        $composant .= "<input type = 'text' class='form-control' name = '$unNom' id = '$unId' ";
        if (!empty($uneValue)){
            $composant .= "value = '$uneValue' ";
        }
        if (!empty($placeholder)){
            $composant .= "placeholder = '$placeholder' aria-label='$placeholder' aria-describedby='$placeholder' ";
        }
        if ($required == 1){
            $composant .= "required ";
        }
        if (!empty($pattern)){
            $composant .= "pattern = '$pattern' ";
        }
        $composant .= "><div class=\"input-group-append\">
                            <input class=\"btn btn-outline-$btnClass\" type=\"button\" value='$btnText' onclick=\"document.getElementById('" . $this->nom . "').submit();\"/>
                        </div></div></div>";
        return $composant;
    }

    public function creerInputSearchCancel($unNom, $unId, $uneValue , $required , $placeholder , $pattern, $btnClassSearch = "light", $btnTextSearch, $btnClassCancel, $btnTextCancel){
        $composant = "<div class='input-group mb-3'>";
        $composant .= "<input type = 'text' class='form-control' name = '" . $unNom . "' id = '" . $unId . "' ";
        if (!empty($uneValue)){
            $composant .= "value = '" . $uneValue . "' ";
        }
        if (!empty($placeholder)){
            $composant .= "placeholder = '" . $placeholder . "' aria-label='$placeholder' aria-describedby='$placeholder' ";
        }
        if ($required == 1){
            $composant .= "required ";
        }
        if (!empty($pattern)){
            $composant .= "pattern = '" . $pattern . "' ";
        }
        $composant .= "><div class=\"input-group-append\">
                            <button class=\"btn btn-outline-$btnClassSearch\" type=\"button\" onclick='document.getElementById('" . $this->nom . "').submit();'>$btnTextSearch</button>
                            <button class=\"btn btn-outline-$btnClassCancel\" type=\"button\" onclick='document.getElementById('" . $this->nom . "').submit();'>$btnTextCancel</button>
                        </div></div>";
        return $composant;
    }

	public function creerInputMdp($unNom, $unId,  $required , $placeholder , $pattern){
		$composant = "<input class='form-control' type = 'password' name = '" . $unNom . "' id = '" . $unId . "' ";
		if (!empty($placeholder)){
			$composant .= "placeholder = '" . $placeholder . "' ";
		}
		if ( $required = 1){
			$composant .= "required ";
		}
		if (!empty($pattern)){
			$composant .= "pattern = '" . $pattern . "' ";
		}
		$composant .= "/>";
		return $composant;
	}

public function creerInputRadio($unnom, $unevaleur,$unLabel){
	$composant="<input type = 'radio' name='" . $unnom . "' value ='". $unevaleur ."'>".$unLabel;
	return $composant;
	}

	public function creerLabelFor($unFor,  $unLabel){
		$composant = "<label for='" . $unFor . "'>" . $unLabel . "</label>";
		return $composant;
	}

	public function creerSelect($unNom, $unId, $options){
		$composant = "<select  name = '$unNom' id ='$unId' class='custom-select' >";
		foreach ($options as $option){
			$composant .= "<option value ='$option'>$option</option>" ;
		}
		$composant .= "</select>";
		return $composant;
	}

    public function creerInputSubmit($unNom, $unId, $uneValue, $class = 'light'){
		$composant = "<input type = 'submit' name = '" . $unNom . "' id = '" . $unId . "' ";
		$composant .= "value = '" . $uneValue . "' class='btn btn-$class' /> ";
		return $composant;
	}

	public function creerInputImage($unNom, $unId, $uneSource){
		$composant = "<input type = 'image' name = '" . $unNom . "' id = '" . $unId . "' ";
		$composant .= "src = '" . $uneSource . "'/> ";
		return $composant;
	}


	public function creerFormulaire(){
		$this->formulaireToPrint = "<form method = '" .  $this->method . "' ";
		$this->formulaireToPrint .= "action = '" .  $this->action . "' ";
		$this->formulaireToPrint .= "name = '" .  $this->nom . "' ";
		$this->formulaireToPrint .= "id = '" .  $this->nom . "' ";
		$this->formulaireToPrint .= "class = '" .  $this->style . "' >";


		foreach ($this->tabComposants as $uneLigneComposants){
			$this->formulaireToPrint .= "<div class = 'ligne'>";
			foreach ($uneLigneComposants as $unComposant){
				$this->formulaireToPrint .= $unComposant ;
			}
			$this->formulaireToPrint .= "</div>";
		}
		$this->formulaireToPrint .= "</form>";
		return $this->formulaireToPrint ;
	}

	public function afficherFormulaire(){
		echo $this->formulaireToPrint ;
	}

	//Créer le lien du pdf
	public function creerLien($unLien, $unNom){
	    $composant = "<a href=". $unLien . ">".$unNom."</a>";
	    return $composant;
	}

}
