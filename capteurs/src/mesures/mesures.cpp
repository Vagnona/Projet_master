#include "mesures.hpp"

/* Public */

float Mesures::genValeur(float borneInf, float borneSupp, bool type) {
	std::random_device rdm;
	std::mt19937 gen(rdm());

	// Génère un float
	std::uniform_real_distribution<double> distr(borneInf, borneSupp);
	const double valeur = distr(gen);

	if (type)
		return trunc(valeur);

	return valeur;
}

void Mesures::updateHumidite() {
	int fd = open(I2C_DEV.c_str(), O_RDWR);

	if (fd < 0)
		return;
	if (ioctl(fd, I2C_SLAVE, HUMIDITE_ADDR) < 0)
		return;

	//requete de lecture
	if (write(fd, HUMIDITE_REGISTRES, 2) != 2)
		return;

	char buffer[2];
	if (read(fd, buffer, 2) != 2)
		return;

	int humidite_absolue = (buffer[1] + (buffer[0] << 8));

	if (humidite_absolue < HUMIDITE_LOW_THRESHOLD)
		humidite_ = 0.0f;
	else
		humidite_ = 100 * ((float)humidite_absolue - HUMIDITE_LOW_THRESHOLD) /
			(HUMIDITE_HIGH_THRESHOLD - HUMIDITE_LOW_THRESHOLD);
}

void Mesures::updateTemperature() {
}

void Mesures::updateLuminosite() {
	int fd = open(I2C_DEV.c_str(), O_RDWR);

	if (fd < 0)
		return;
	if (ioctl(fd, I2C_SLAVE, LUMINOSITE_ADDR) < 0)
		return;

	//Configuration du capteur
	if (write(fd, "\0\0\0", 3) != 3)
		return;

	//requete de lecture
	if (write(fd, LUMINOSITE_REGISTRES, 2) != 2)
		return;

	char buffer[2];
	if (read(fd, buffer, 2) != 2)
		return;

	luminosite_ = (buffer[1] + (buffer[0] << 8));
}