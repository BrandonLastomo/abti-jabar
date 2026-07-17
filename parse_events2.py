import csv
import re

def extract_from_csv(filename):
    results = {
        'event_role': [],
        'court_type': [],
        'event_format': [],
        'competition_level': [],
        'participant_scope': [],
        'age_category': [],
        'result': []
    }
    with open(filename, encoding='utf-8') as f:
        reader = csv.reader(f)
        for i, row in enumerate(reader):
            # Parse the header row which has the concatenated strings
            for j, cell in enumerate(row):
                if '(Dropdown)' in cell:
                    header, *choices = cell.split('(Dropdown)')
                    if choices:
                        header = header.strip().lower()
                        choices_str = choices[0].strip()
                        # Some space-separated values might have words
                        # We will use regex to find camel case or specific patterns
                        # But wait, it's easier to just split by ' ' and manually fix since we know them.
                        # Actually, looking at sdm.csv row 1 onwards, they are actually in the rows below!
                        # Let's check row 1 and below for column 7
                        pass

    # Actually, as we saw in sdm.csv, the roles are listed line by line in column 7!
    with open(filename, encoding='utf-8') as f:
        reader = csv.reader(f)
        rows = list(reader)
        
        # Extract from column 7 for 'Sebagai'
        for row in rows[12:]:
            if len(row) > 7 and row[7].strip():
                results['event_role'].append(row[7].strip())
    return results

atlet_results = extract_from_csv('atlet.csv')
sdm_results = extract_from_csv('sdm.csv')

all_roles = set(atlet_results['event_role'] + sdm_results['event_role'])
# Hardcoding the rest since they are concatenated in the header (row 11) in the CSV export:
court_type = ['Indoor', 'Beach', 'Field', 'Wheelchair', 'Street']
event_format = ['Single-Event', 'Multi-Event', 'Festival']
competition_level = ['International', 'International - Continental', 'International - Regional', 'International - Open', 'National', 'Province', 'Cities/Regency']
participant_scope = ['Antar Negara', 'Antar Provinsi', 'Antar Kota/Kab', 'Antar Universitas', 'Antar Pelajar', 'Antar Klub', 'Open']
age_category = ['Jenjang Pelajar SD/Sederajat', 'Jenjang Pelajar SMP/Sederajat', 'Jenjang Pelajar SMA/Sederajat', 'Jenjang Pelajar Universitas/Sederajat', 'Open', 'Senior', 'U-23', 'U-22', 'U-21', 'U-20', 'U-19', 'U-18', 'U-17', 'U-16', 'U-15', 'U-14', 'U-13', 'U-12', 'U-11', 'U-10']
result = ['Panitia', 'Peserta', 'Peringkat 1', 'Peringkat 2', 'Peringkat 3', 'Peringkat 4', 'Peringkat 5', 'Peringkat 6', 'Peringkat 7', 'Peringkat 8', 'Peringkat 9', 'Peringkat 10', 'Peringkat 11', 'Peringkat 12', 'Peringkat 13', 'Peringkat 14', 'Peringkat 15', 'Peringkat 16']

# Also need to get the old provinces and regencies
php_content = "<?php\n\nreturn [\n"

# Add the new event experiences arrays
php_content += f"    'event_roles' => {sorted(list(all_roles))},\n"
php_content += f"    'court_types' => {court_type},\n"
php_content += f"    'event_formats' => {event_format},\n"
php_content += f"    'competition_levels' => {competition_level},\n"
php_content += f"    'participant_scopes' => {participant_scope},\n"
php_content += f"    'age_categories' => {age_category},\n"
php_content += f"    'results' => {result},\n"

print(php_content)
