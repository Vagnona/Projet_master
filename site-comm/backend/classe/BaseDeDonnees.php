<?php

include_once "Message.php";

class BaseDeDonnees {
	private $pdo;
	public $error;

	/* Constructeur */
	/**
	 * Créé le dossier de la base de données s'il n'existe pas
	 *
	 * @param string $chemin Le chemin vers la base de données
	 */
	public function __construct($chemin) {
		try {
			if (!file_exists(dirname($chemin))) {
				mkdir(dirname($chemin), 0777, true);
			}

			$this->pdo = new PDO("sqlite:$chemin");
		}
		catch (PDOException $exception) {
			$this->error = $exception;
		}
	}

	/* Fonctions */
	/**
	 * Initialise la table de la base de données
	 *
	 * @return void
	 */
	public function initialiserTable() {
		$this->pdo->query("
			CREATE TABLE IF NOT EXISTS contacts (
				id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
				nom VARCHAR(100) NOT NULL,
				prenom VARCHAR(100) NOT NULL,
				courriel TEXT NOT NULL,
				message TEXT NOT NULL
			)");
	}

	/**
	 * Insère un message dans la base de données
	 *
	 * @param string $nom Le nom de l'expéditeur
	 * @param string $prenom Le prénom de l'expéditeur
	 * @param string $courriel Le courriel de l'expéditeur
	 * @param string $message Le message de l'expéditeur
	 * @return int|null 2 si erreur, sinon null
	 */
	public function insererMessage(
		string $nom,
		string $prenom,
		string $courriel,
		string $message
	){
		$contact = new Messages();
		try {
			$contact->nouveauMessage($nom, $prenom, $courriel, $message);
			$statement = $this->pdo->prepare("
				INSERT INTO contacts (nom, prenom, courriel, message)
				VALUES (:nom, :prenom, :courriel, :message)
			");
			$statement->bindValue("nom", $contact->getNom());
			$statement->bindValue("prenom", $contact->getPrenom());
			$statement->bindValue("courriel", $contact->getCourriel());
			$statement->bindValue("message", $contact->getMessage());
			$statement->execute();
		}
		catch (Exception $exception) {
			return 2;
		}
	}
}