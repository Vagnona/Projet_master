<?php

define("regexInput", "#^[\S\s]{1,100}$#");
define("regexCourriel", "#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-z]{1,}$#");

class Messages {
	private $nom, $prenom, $courriel, $message;

	/* Fonction */
	/**
	 * Créé un objet pour un nouveau message
	 *
	 * @param string $nom Le nom de l'expéditeur
	 * @param string $prenom Le prénom de l'expéditeur
	 * @param string $courriel Le courriel de l'expéditeur
	 * @param string $message Le message de l'expéditeur
	 */
	public function nouveauMessage(
		string $nom,
		string $prenom,
		string $courriel,
		string $message
	){
		$this->setNom($nom);
		$this->setPrenom($prenom);
		$this->setCourriel($courriel);
		$this->setMessage($message);
	}

	/* Getters */
	public function getNom() {
		return $this->nom;
	}
	public function getPrenom() {
		return $this->prenom;
	}
	public function getCourriel() {
		return $this->courriel;
	}
	public function getMessage() {
		return $this->message;
	}

	/* Setters */
	public function setNom(string $nom) {
		if (($nom !== '') && (preg_match(regexInput, $nom))) {
			$this->nom = $nom;
		}
		else {
			throw new Exception("Le nom n'a pas le bon format");
		}
	}
	public function setPrenom(string $prenom) {
		if (($prenom !== '') && (preg_match(regexInput, $prenom))) {
			$this->prenom = $prenom;
		}
		else {
			throw new Exception("Le prénom n'a pas le bon format");
		}
	}
	public function setCourriel(string $courriel) {
		if (($courriel !== '') && (preg_match(regexCourriel, $courriel))) {
			$this->courriel = $courriel;
		}
		else {
			throw new Exception("Le courriel n'a pas le bon format");
		}
	}
	public function setMessage(string $message) {
		if ($message !== '') {
			$this->message = $message;
		}
		else {
			throw new Exception("Le message n'a pas le bon format");
		}
	}
}