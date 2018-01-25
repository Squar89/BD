#include <cstdio>
#include <cstdlib>
#include <iostream>
#include <fstream>
#include <map>
#include <string>
#include <vector>
using namespace std;

typedef struct Movie {
    int id;
    string title;
    string yearProduced;
    int runtime;
    string language;
    double voteAvg;
    int votes;
    int directorId;
} Movie;

typedef struct Director {
    int directorId;
    string firstName;
    string lastName;
} Director;

map <int, Movie> moviesMap;
vector <Director> directorsVector;

int addDirector(string firstName, string lastName) {
    for (int i = 0; i < directorsVector.size(); i++) {
        if (directorsVector[i].firstName == firstName && directorsVector[i].lastName == lastName) {
            return i + 1;
        }
    }

    Director director = {int(directorsVector.size() + 1), firstName, lastName};
    directorsVector.push_back(director);

    return directorsVector.size();
}

int main() {
    string line;

    int id;
    string language;
    string yearProduced;
    int runtime;
    string title;
    double voteAvg;
    int votes;

    ifstream movies("Movies.csv");
    if (movies.is_open()) {
        getline(movies, line);
        while (getline(movies, line)) {
            //cout << line << endl;

            const char *c_line1 = line.c_str();
            id = strtoul(c_line1, NULL, 0);
            line = line.substr(line.find(';') + 1);
            language = line.substr(0, 2);
            yearProduced = line.substr(3, 4);
            line = line.substr(14);
            const char *c_line = line.c_str();
            runtime = strtoul(c_line, NULL, 0);
            c_line = strchr(c_line, ';') + 1;
            title = c_line;
            title = title.substr(0, title.find(';'));
            c_line = strchr(c_line, ';') + 1;
            voteAvg = strtod(c_line, NULL);
            c_line = strchr(c_line, ';') + 1;
            votes = strtoul(c_line, NULL, 0);

            //cout << id << endl << language << endl << yearProduced << endl << runtime << endl << title << endl << voteAvg << endl << votes << endl;

            Movie movie = {id, title, yearProduced, runtime, language, voteAvg, votes, 0};
            moviesMap.insert(make_pair(id, movie));
        }
        movies.close();
    }
    else cout << "Unable to open file movies";

    int directorId;
    string firstName, lastName;
    
    ifstream credits("Credits.csv");
    if (credits.is_open()) {
        getline(credits, line);
        while (getline(credits, line)) {
            //cout << line << endl;

            const char *c_line = line.c_str();
            id = strtoul(c_line, NULL, 0);

            int namePos = line.find("Director\"\", \"\"name\"\":");
            //cout << namePos << endl;
            if (namePos != string::npos) {
                namePos += 23;
                line = line.substr(namePos, 100);
                firstName = line.substr(1, line.find(' ') - 1);
                line = line.substr(line.find(' ') + 1, 100);
                lastName = line.substr(0, line.find('"'));

                //cout << firstName << endl << lastName << endl;

                directorId = addDirector(firstName, lastName);

                auto it = moviesMap.find(id);
                if (it != moviesMap.end()) {
                    it->second.directorId = directorId;
                }
            }
            else {
                moviesMap.erase(id);
            }
        }

    }
    else cout << "Unable to open file credits";

    
}