#include <iostream>
#include <algorithm> 
#include <vector>    // vektor || monozina
#include <list>      
#include <set>       
#include <string>  	 

using namespace std;      

//login:matias02 
//Aleš Matiášek
//visual studio + visual code

// Hashovací tabulka je datová struktura implementující rozhraní pole,
//Umožňuje ukládat dvojice (klíč, hodnota) 
//Lze provádět 3 druhy operace: přidání nového páru, operace vyhledávání a operaci odstranění páru podle klíče.

template<typename Key, typename Value> struct hash_table {
private:
	// Tabulka ukládá několik hodnot (klíč, seznam hodnot).
	// Pro každou položku seznam studentů registrovaných na tuto položku.
	vector<pair<Key, list<Value>>> table;
	int size;
public:
	hash_table() {			//verejny konstruktor 
		size = 0;
		table.resize(10);               // Vytvarime hash tabulku s velikostí 10
	}

	double load_factor() {                 // // koeficient plnění hash tabulky
		return 1.0 * size / table.size(); // Počet uložených elementu dělený velikostí tabulky (na začatku 0/10)
	}

	int f(int key) {                     // Hash hodnoty čísla
		unsigned long long x = key;     // 0 až 18 446 744 073 709 551 615   pro 64bit
		x += 0x9e3779b97f4a7c15;          //nahodny rozmer tabulky
		x = (x ^ (x >> 30)) * 0xbf58476d1ce4e5b9;  	//>> pravy posun bitu o 30 
		x = (x ^ (x >> 27)) * 0x94d049bb133111eb;	//>> pravy posun bitu o 27
		return (x ^ (x >> 31)) % table.size();
	}

	int hash_func(Key key) {
		return f(key.to_integer());    // Hash funkce. Třída klíče musí mít funkci to_integer
	}

	void rebuild() {                     //S nárůstem položek v tabulce hash se zvyšuje doba provozu, takže po dosažení určitého poměru obsazenosti znovu vytvoříme tabulku hash s dvojnásobnou velikostí.
		vector<pair<Key, list<Value>>> old_table(table.size() * 2);
		old_table.swap(table);
		size = 0;
		for (int i = 0; i < old_table.size(); i++) {
			for (auto it = old_table[i].second.begin(); it != old_table[i].second.end(); it++) {
				insert(old_table[i].first, *it);
			}
		}
	}

	bool insert(Key key) { // Funkce pro přidání nového klíče do hash tabulky.
		/*
		 Algoritmus vkládání prvku zkontroluje buňky pole H v určitém pořadí, dokud není nalezena první volná buňka, do které bude nový prvek zapsán. Wiki(c)
		*/
		int hash = hash_func(key);
		while (table[hash].first != Key() && table[hash].first != key) {
			hash = (hash + 1) % table.size(); 		//modulo delení 
		}

		if (table[hash].first == key) {
			return false;
		}

		size++;
		table[hash].first = key;

		if (load_factor() > 0.6) {
			rebuild();
		}
		return true;
	}


	bool insert(Key key, Value value) { // Funkce pro přidání nového páru (klíč, hodnota) do tabulky hash.
		if (find(key, value)) return false;
		int hash = hash_func(key);
		while (!table[hash].second.empty() && table[hash].first != key) {
			hash = (hash + 1) % table.size();
		}

		size++;
		table[hash].first = key;
		table[hash].second.push_back(value);
		if (load_factor() > 0.6) {
			rebuild();
		}
		return true;
	}

	bool find(Key key) { // Funkce pro vyhledávání klíčů
		int hash = hash_func(key);
		while (!table[hash].second.empty() && table[hash].first != key) {
			hash = (hash + 1) % table.size();
		}

		return table[hash].first == key;
	}

	bool find(Key key, Value value) { // Funkce pro hledání dvojice (klíč, hodnota)
		int hash = hash_func(key);
		while (!table[hash].second.empty() && table[hash].first != key) {
			hash = (hash + 1) % table.size();
		}

		if (table[hash].second.empty()) { // Pokud je seznam prázdný, pak tento pár neexistuje
			return false;
		}

		for (auto it = table[hash].second.begin(); it != table[hash].second.end(); it++) { // Iterujeme celý seznam a snažíme se najít položku
			if (*it == value) {
				return true;
			}
		}

		return false;
	}

	list<Value> get_values(Key key) { // Funkce pro získání seznamu položek pro konkrétní klíč. Pro seznam studentů registrovaných na konkrétní předmět.
		int hash = hash_func(key);
		while (!table[hash].second.empty() && table[hash].first != key) {
			hash = (hash + 1) % table.size();
		}

		return table[hash].second;
	}

	bool erase(Key key) { //Funkce pro odstranění klíče z hash tabulky
		int hash = hash_func(key);
		while (!table[hash].second.empty() && table[hash].first != key) {
			hash = (hash + 1) % table.size();
		}

		if (table[hash].second.empty()) {
			return false;
		}

		// Čištění polí
		table[hash].first = Key();
		table[hash].second.clear();
		return true;
	}

	bool erase(Key key, Value value) { // Funkce pro odstranění dvojice (klíč, hodnota) z hash tabulky
		int hash = hash_func(key);
		while (!table[hash].second.empty() && table[hash].first != key) {
			hash = (hash + 1) % table.size();
		}

		if (table[hash].second.empty()) {
			return false;
		}

		for (auto it = table[hash].second.begin(); it != table[hash].second.end(); it++) {
			if (*it == value) {
				table[hash].second.erase(it);
				return true;
			}
		}

		return false;
	}

	vector<Key> get_keys() { // Funkce pro získání všech klíčů v tabulce hash. Pro urcitz seznam položek.
		vector<Key> result;
		for (int i = 0; i < table.size(); i++) {
			if (table[i].first != Key()) {
				result.push_back(table[i].first);
			}
		}
		return result;
	}
};//end template<typename Key, typename Value> struct hash_table 


// Struktura pro ukládání dat o předmětu.
struct subject {
private:
	string name;
public:
	subject() {}
	subject(const subject& sub) : name(sub.name) {}
	subject(const string& name) : name(name) {}

	void set_name(const string& name) {
		this->name = name;
	}

	string get_name() {
		return name;
	}

	// Funkce porovnávání položek. Položky jsou porovnávány lexiograficky

	friend bool operator < (const subject& s1, const subject& s2) {
		return s1.name < s2.name;
	}

	friend bool operator > (const subject& s1, const subject& s2) {
		return s1.name > s2.name;
	}

	friend bool operator == (const subject& s1, const subject& s2) {
		return s1.name == s2.name;
	}

	friend bool operator != (const subject& s1, const subject& s2) {
		return s1.name != s2.name;
	}

	// Chcete-li použít tabulky hash, potřebujete funkci hash. V tomto programu se hash funkce rovná prvnímu znaku vynásobenému posledním znakem řetězce.
	int to_integer() {
		if (name.size() == 1) {
			return (int)name[0];
		}
		else {
			return (int)name[0] * name.back();
		}
	}
};//end struct subject {

// Struktura pro ukládání dat o studentovi. Data obsahují 3 Pole, to je id, celé jméno a skupina studenta.
struct student {
private:
	int id;
	string full_name;
	string group;
public:
	student() : id(0) {}
	student(const int& id) : id(id) {}
	student(const int& id, const string& full_name, const string& group) : id(id), full_name(full_name), group(group) {}
	student(const student& st) : id(st.id), full_name(st.full_name), group(st.group) {}

	void set_id(const int& id) {
		this->id = id;
	}

	void set_full_name(const string& full_name) {
		this->full_name = full_name;
	}

	void set_group(const string& group) {
		this->group = group;
	}

	int get_id(const int& id) {
		return id;
	}

	string get_full_name() {
		return full_name;
	}

	string get_group() {
		return group;
	}

	// Přetižemí operátorů srovnání. Studenti jsou porovnávány podle jejich id. Rovnost id znamená rovnost samotných studentů.
	friend bool operator < (const student& s1, const student& s2) {
		return s1.id < s2.id;
	}

	friend bool operator > (const student& s1, const student& s2) {
		return s1.id > s2.id;
	}

	friend bool operator == (const student& s1, const student& s2) {
		return s1.id == s2.id;
	}

	friend bool operator != (const student& s1, const student& s2) {
		return s1.id != s2.id;
	}

	// Přetížení I/O operátora konzoly pro výstup informací o studentovi.
	friend ostream& operator << (ostream& os, const student& st) {
		os << "ID: " << st.id << endl;
		os << "Jmeno: " << st.full_name << endl;
		os << "Skupina: " << st.group;
		return os;
	}
};

// Funkce pro čtení řádku
string readline() {
	string s;
	char c;
	do {
		c = getchar(); // getchar - funkce pro čtení jednoho znaku. Zbavíme se zbytečných mezer.
	} while (c == ' ' || c == '\n');
	while (c != '\n') {
		s += c;
		c = getchar();
	}
	return s;
}

bool is_integer(const string& s) {
	/*
	Funkce kontroluje, zda je daný řádek číslem.
	*/
	for (const char& c : s) {
		if (!isdigit(c)) {
			return false;
		}
	}
	return true;
}

/// Funkce pro přidání nového studenta.
void add_student(set<student>& students) {
	cout << "--- Pridavani studenta ---" << endl; 
	student new_student;				//polozka struktury
	int id;								// id studenta
	while (true) {
		cout << "ID: ";
		string temp;					//vstupní řetezec
		cin >> temp; // Čteme data. Před přečtením čísel, jsou čteny jako řetězec, pak zkontrolujme zda daný řádek je číslo a pak přiřazujem
		if (!is_integer(temp)) { // Kontrola správnosti zadaného čísla
			cout << "Neplatny rozsah !!!" << endl;		
		}
		else {
			id = stoi(temp); // stoi -funkce pro převod na číslo řádku
			if (students.count(student(id))) { //Funkce count ověřuje přítomnost studenta s takovým id
				cout << "Takove ID student jiz existuje !!!" << endl;
			}
			else {
				break;
			}
		}
	}//end while

	new_student.set_id(id);
	cout << "Jmeno: ";
	string full_name = readline();
	new_student.set_full_name(full_name);
	cout << "Skupina: ";
	string group = readline();
	new_student.set_group(group);
	students.insert(new_student);
	cout << "ZAPSANO" << endl;
}

// Funkce pro predmetu 
void add_subject(hash_table<subject, student>& registrations) {
	cout << "--- pridani predmetu ---" << endl;
	subject new_subject;				// polozka struktury
	cout << "Nazev predmetu: ";
	string name = readline();				
	new_subject.set_name(name);
	if (registrations.insert(new_subject)) { // test na stejny nazev
		cout << "ZAPSANO" << endl;
	}
	else {
		cout << "Predmet s timto nazvem jiz existuje" << endl;
	}
}

// Funkce pro registraci studenta. Zadejte id studenta, pak se zobrazí seznam položek, zadejte číslo a přidejte do seznamu registrovaných
void registrate_student(set<student>& students, hash_table<subject, student>& registrations) {
	int id;				// id registrace 
	while (true) {
		cout << "Student id: ";
		string temp; 
		cin >> temp;
		if (!is_integer(temp)) {
			cout << "Neplatny rozsah !!!" << endl;
		}
		else {
			id = stoi(temp);
			if (!students.count(student(id))) {
				cout << "Student s timto ID neexistuje" << endl;
			}
			else {
				break;
			}
		}
	}

	// Zobrazit seznam položek.
	cout << "Prehled predmetu:" << endl;
	int i = 1;
	vector<subject> all_subjects = registrations.get_keys();
	for (subject sub : all_subjects) {
		cout << i << ". " << sub.get_name() << endl;
		i++;
	}

	student st = *students.find(student(id));
	cout << i << ". " << "Pridat predmet" << endl; // Dáme uživateli možnost Přidat nový předmět přímo zde.
	int j;
	while (true) {
		cout << "Select: ";
		string temp;
		cin >> temp;
		if (!is_integer(temp)) {
			cout << "Neplatny rozsah !!!" << endl;
		}
		else {
			j = stoi(temp);
			if (j < 1 || j > i) {
				cout << "Neplatny rozsah !!!" << endl;
			}
			else {
				break;
			}
		}
	}//end while



	if (j == i) { // Pokud se uživatel rozhodne přidat novou položku, poprosim zadat název položky
		cout << "Nazev predmetu: ";
		string name = readline();
		subject new_subject;
		new_subject.set_name(name);
		if (registrations.insert(new_subject)) {
			cout << "ZAPSANO" << endl;
			all_subjects.push_back(new_subject);
		}
		else {
			cout << "Tento predmet jiz existuje" << endl;
			for (int i = 0; i < all_subjects.size(); i++) {
				if (all_subjects[i] == new_subject) {
					j = i + 1;
					break;
				}
			}
		}
	}
	if (registrations.insert(all_subjects[j - 1], st)) { // Přidáme pár (předmět, student) do hash tabulky a v závislosti na tom, zda byl dříve registrován tento student v tomto předmětu 
		cout << "ZAPSANO" << endl;
	}
	else {
		cout << "Student je jiz na tento predmet zapsan" << endl;
	}
}

// Funkce pro zrušení registrace. K tomu najdeme studenta v množine studentů. Zadejte název předmětu a pokud byl tento student skutečně zapsán do tohoto předmětu, odstraňte jej z tabulky hash
void registrate_cancel(set<student>& students, hash_table<subject, student>& registrations) {
	int id;
	while (true) {
		cout << "Student id: ";
		string temp;
		cin >> temp;
		if (!is_integer(temp)) {
			cout << "Neplatny vstup !!!" << endl;
		}
		else {
			id = stoi(temp);
			if (!students.count(student(id))) {
				cout << "Stundet s timto ID neexistuje" << endl;
			}
			else {
				break;
			}
		}
	}

	student st = *students.find(student(id));
	cout << "Subject name: ";
	string subject_name = readline();
	if (!registrations.find(subject(subject_name))) {
		cout << "A subject with this name not exists" << endl;
	}
	else {
		if (registrations.erase(subject(subject_name), st)) {
			cout << "SMAZANO" << endl;
		}
		else {
			cout << "Was not registered for this subject " << endl;
		}
	}
}

// Funkce pro vypis studentů registrovaných v určitém předmětu
void print_registered_students(hash_table<subject, student>& registrations) {
	
	cout << "--- Vypis ---" << endl;
	int i = 1;
	vector<subject> all_subjects = registrations.get_keys();
	for (subject sub : all_subjects) {
		cout << i << ". " << sub.get_name() << endl;
		i++;
	}
	int j;
	while (true) {
		cout << "Vyber cislo predmetu: ";
		string temp;
		cin >> temp;			// neni upozorneni kdyz nejsou predmety
		if (!is_integer(temp)) {
			cout << "Neplatny rozsah !!!" << endl;
		}
		else {
			j = stoi(temp);
			if (j < 1 || j >= i) {
				cout << "Neplatny rozsah !!!" << endl;
			}
			else {
				break;
			}
		}
	}


	cout << "Vypis registorvanych studentu" << endl;
	for (student st : registrations.get_values(subject(all_subjects[j - 1]))) {
		cout << st << endl;
		cout << "" << endl; //odradkovani mezi studenty
	}
	system("pause");
}


int main()
{
	set<student> students; // Možina studentů. set - standardní datová struktura v C++. O ní si můžete přečíst zde https://en.cppreference.com/w/cpp/container/set
	hash_table<subject, student> registrations; // Naše hash tabulka. Ukládá pár (předmět, student)
	//while jedna
	
	cout << "login:matias02" << endl;
	cout << "Pridat predmet" << endl;

	while (true) {
		// Menu
		system("cls");    // smaze konzoli (pouze windwos)
		cout << "------------------" << endl;
		cout << "| login:matias02 |" << endl;
		cout << "|    matias02_sp |" << endl; 
		cout << "------------------" << endl;

		cout << "1. Pridat studenta" << endl;  
		cout << "2. Pridat predmet" << endl; 
		cout << "3. Registrovat studenta na zkousku" << endl;  
		cout << "4. Zrusit registaci" << endl;  
		cout << "5. Vypis regisrovanych studentu" << endl;  
		cout << "7. Vypis vsech studentu" << endl;
		cout << "6. KONEC" << endl;     
		int t;
		//while dva
		while (true) {
			cout << "Vyber: ";
			string temp;  //vstup jako retec 
			cin >> temp;  // co je na vstupu se ulozi do temp 
			if (!is_integer(temp)) {
				cout << "Neplatny rozsah !!!" << endl;  //neplatny rozsah
			}
			else {
				t = stoi(temp);  //stoi prevede string na int 
				if (!(t >= 1 && t <= 6)) {    
					cout << "Neplatny rozsah !!!" << endl;
				}
				else {
					break;
				}
			}
		} //end while dva

		if (t == 1) {
			add_student(students);
		}
		else if (t == 2) {
			add_subject(registrations);
		}
		else if (t == 3) {
			registrate_student(students, registrations);
		}
		else if (t == 4) {
			registrate_cancel(students, registrations);
		}
		else if (t == 5) {
			print_registered_students(registrations);
		}
		else if (t == 6) {
			break;
		}
	

		cout << "Klikni pro pokracovani..." << endl;
		char c = getchar();   
	}//end while jedna
}// end main