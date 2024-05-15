#ifndef INFOS_CHAMP_H
#define INFOS_CHAMP_H

class InfosChamp {
	/* Variables */
	private:
		int idAgri_;
		int idChamp_;
		int idIlot_;


	/* Constructeur et destructeur */
	public:
		InfosChamp(void) = default;
		~InfosChamp(void) = default;


	/* Getters */
	public:
		inline int getIdAgri(void) const {
			return idAgri_;
		}
		inline int getIdChamp(void) const {
			return idChamp_;
		}
		inline int getIdIlot(void) const {
			return idIlot_;
		}


	/* Setters */
	public:
		inline void setInfosChamp(int idAgri, int idChamp, int idIlot) {
			this->idAgri_ = idAgri;
			this->idChamp_ = idChamp;
			this->idIlot_ = idIlot;
		}
};

#endif