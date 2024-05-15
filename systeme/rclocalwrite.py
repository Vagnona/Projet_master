import fileinput
import os

def add_test_above_second_exit_0(file_path):
    exit_0_count = 0

    # Récupère le nom de l'utilisateur pour le répertoire  ~/
    user = ""
    if os.geteuid() == 0:
        user = os.getenv('SUDO_USER')
    else:
        user = os.getlogin()

    # Liste pour stocker les lignes modifiées
    modified_lines = []

    with fileinput.input(file_path, inplace=True) as file:
        for line in file:
            # Compter les occurrences de "exit 0"
            if line.strip() == "exit 0":
                exit_0_count += 1

            # Ajouter la ligne "test" juste avant la deuxième occurrence de "exit 0"
            if exit_0_count == 1:
                modified_lines.append("/home/"+user+"/start-batman-adv.sh &\n")

            # Ajouter la ligne originale
            modified_lines.append(line)

    # Écrire les modifications dans le fichier
    with open(file_path, 'w') as file:
        file.writelines(modified_lines)

if __name__ == "__main__":
    file_path = "/etc/rc.local"  # Remplacez par le chemin de votre fichier
    add_test_above_second_exit_0(file_path)
