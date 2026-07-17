import csv

provinces = set()
other_regencies = []
birth_regencies = []

with open('sheet.csv', encoding='utf-8') as f:
    reader = csv.reader(f)
    for row in reader:
        # Check column 1 (Regency with Kab.) and 2 (Province)
        if len(row) >= 3:
            reg1, prov1 = row[1].strip(), row[2].strip()
            if prov1 and prov1 != "Provinsi": # Ignore header
                provinces.add(prov1)
                if reg1 and reg1 != "Kab. / Kota":
                    other_regencies.append(reg1)
        
        # Check column 4 (Regency without Kab.) and 5 (Province)
        if len(row) >= 6:
            reg2, prov2 = row[4].strip(), row[5].strip()
            if prov2 and prov2 != "Provinsi":
                provinces.add(prov2)
                if reg2 and reg2 != "Kab. / Kota":
                    birth_regencies.append(reg2)

provinces = sorted(list(provinces))
other_regencies = sorted(list(set(other_regencies)))
birth_regencies = sorted(list(set(birth_regencies)))

php_content = "<?php\n\nreturn [\n"
php_content += "    'provinces' => [\n        " + ",\n        ".join([f"'{p}'" for p in provinces]) + "\n    ],\n"
php_content += "    'birth_regencies' => [\n        " + ",\n        ".join([f"'{r}'" for r in birth_regencies]) + "\n    ],\n"
php_content += "    'other_regencies' => [\n        " + ",\n        ".join([f"'{r}'" for r in other_regencies]) + "\n    ]\n];"

with open('config/dropdown.php', 'w', encoding='utf-8') as out:
    out.write(php_content)
print("dropdown.php updated successfully!")
