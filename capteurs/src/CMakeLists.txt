# Ajoute tous les fichiers .cpp dans le dossier src
file(GLOB SOURCES_COMMMUNES "${PROJECT_SOURCE_DIR}/src/commun/*.cpp")
file(GLOB SOURCES_1 "${PROJECT_SOURCE_DIR}/src/mesures/*.cpp")
file(GLOB SOURCES_2 "${PROJECT_SOURCE_DIR}/src/agregateur/*.cpp")

# Combine les fichiers communs et les fichiers spécifiques à chaque programme
set(PROGRAMME1_SOURCES ${SOURCES_COMMMUNES} ${SOURCES_1})
set(PROGRAMME2_SOURCES ${SOURCES_COMMMUNES} ${SOURCES_2})

# Défini le nom des exécutables
set(PROGRAMME1_NOM "mesures")
set(PROGRAMME2_NOM "agregateur")

# Défini le standard à appliquer
set(CMAKE_CXX_STANDARD 17)

# Ajoute les dossiers des headers
if(APPLE)
	link_directories(/usr/local/include/libssh2/lib)
	include_directories(/usr/local/include/libssh2/include)
endif()

include_directories(${PROJECT_SOURCE_DIR}/inc/commun)
include_directories(${PROJECT_SOURCE_DIR}/inc/mesures)
include_directories(${PROJECT_SOURCE_DIR}/inc/agregateur)

# Récupère la variable PROG_TYPE depuis la commande cmake build
option(PROG_TYPE "Type de programme" mesures)

# Défini le nom de l'exécutable et son emplacement
if(PROG_TYPE STREQUAL "mesures" OR PROG_TYPE STREQUAL "all")
	add_executable(${PROGRAMME1_NOM} ${PROGRAMME1_SOURCES})
	set(EXECUTABLE_OUTPUT_PATH ${PROJECT_SOURCE_DIR}/bin)
	target_include_directories(${PROGRAMME1_NOM}
		PRIVATE
		${CMAKE_CURRENT_SOURCE_DIR}/src/main1
	)
	target_link_libraries(${PROGRAMME1_NOM} ssh2)
endif()

if(PROG_TYPE STREQUAL "agregateur" OR PROG_TYPE STREQUAL "all")
	add_executable(${PROGRAMME2_NOM} ${PROGRAMME2_SOURCES})
	set(EXECUTABLE_OUTPUT_PATH ${PROJECT_SOURCE_DIR}/bin)
	target_include_directories(${PROGRAMME2_NOM}
		PRIVATE
		${CMAKE_CURRENT_SOURCE_DIR}/src/main2
	)
	target_link_libraries(${PROGRAMME2_NOM} ssh2)
endif()

if(
	NOT (PROG_TYPE STREQUAL "mesures" OR PROG_TYPE STREQUAL "agregateur" OR
	PROG_TYPE STREQUAL "all")
)
	message(FATAL_ERROR "Type de programme inconnu")
endif()