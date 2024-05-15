#ifndef MESURES_H
#define MESURES_H

#include <fcntl.h>
#include <linux/i2c-dev.h>
#include <random>
#include <sys/ioctl.h>
#include <unistd.h>

class Mesures {
	/* Variables */
	private:
		std::string date_;
		float temperature_;
		float humidite_;
		double luminosite_;

		static constexpr int HUMIDITE_HIGH_THRESHOLD = 520;
		static constexpr int HUMIDITE_LOW_THRESHOLD = 400;
		static constexpr int HUMIDITE_ADDR = 0x36;

		// Valeurs donnés ici : https://learn.adafruit.com/adafruit-stemma-soil-sensor-i2c-capacitive-moisture-sensor/faq
		static constexpr unsigned char HUMIDITE_REGISTRES[] = {
				0x0F, // base register
				0x10  // function register
		};
		static constexpr int LUMINOSITE_ADDR = 0x10;

		// Valeurs donnés ici : https://www.vishay.com/docs/84286/veml7700.pdf
		static constexpr unsigned char LUMINOSITE_REGISTRES[] = {
				0x04,
				0x0
		};

		const std::string I2C_DEV = "/dev/i2c-1";

	/* Constructeur et destructeur */
	public:
		Mesures(void) = default;
		~Mesures(void) = default;


	/* Getters */
	public:
		inline std::string getDate(void) const {
			return date_;
		}
		inline float getTemperature(void) const {
			return temperature_;
		}
		inline float getHumidite(void) const {
			return humidite_;
		}
		inline double getLuminosite(void) const {
			return luminosite_;
		}


	/* Setters */
	public:
		inline void setDate(std::string date) {
			this->date_ = date;
		}
		inline void setTemperature(float temperature) {
			this->temperature_ = temperature;
		}
		inline void setHumidite(float humidite) {
			this->humidite_ = humidite;
		}
		inline void setLuminosite(double luminosite) {
			this->luminosite_ = luminosite;
		}


	/* Méthodes */
	private:
		void updateHumidite(void);
		void updateLuminosite(void);
		void updateTemperature(void);

	public:
		/**
		 * @brief Génère une valeur aléatoires entre borneInf et borneSupp
		 *
		 * @param borneInf la borne inférieur
		 * @param borneSupp la borne supérieur
		 * @param type le type de valeur à générer (0 = float | 1 = double)
		 * @return float/double la valeur aléatoire générée
		 */
		static float genValeur(float borneInf, float borneSupp, bool type);
};

#endif