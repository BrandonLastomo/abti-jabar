import json
import ast
import re

# Read current dropdown.php
with open('config/dropdown.php', 'r', encoding='utf-8') as f:
    content = f.read()

event_roles = ['Agent (Player Agent)', 'Ahli Hukum (Olahraga)', 'Analis Performa', 'Appointed Physician', 'Asisten Pelatih Olahraga', 'Athlete', 'B Sample Opening Witness', 'Chairman of Competition Management', 'Chaperone', 'Co-worker', 'Coach', 'Competition Manager', 'Data Analyst', 'Direktur Teknis', 'Dokter Olahraga', 'Doping Control Officer', 'Doping Control Official', 'Doping Official', 'Event Delegate', 'Event Director', 'Event Manager', 'Fasilitator Olahraga', 'Fisiolog Olahraga', 'Fisioterapis', 'Fitness Coach', 'Goalkeeper Coach', 'Head of Delegation', 'Independent Observer', 'Inspection Delegates', 'Instruktur', 'Interpreter', 'Jurnalis Olahraga', 'Konsultan Industri Olahraga', 'Lecturers', 'Liaison Officer', 'Living Assistant', 'Manajer Stadion', 'Marshall', 'Match Analysts', 'Media Officer', 'Media Publisher', 'Media Representative', 'Medis Pertandingan', 'Medis Tim', 'Mekanik', 'Multiplier', 'Nutrisionis Olahraga', 'Operator IT', 'Operator Pertandingan', 'Operator Skor', 'Pelatih Ekstrakurikuler', 'Pelatih Fisik', 'Pelatih Fisik Disabilitas', 'Pelatih Kelas Khusus Olahraga', 'Pelatih Kepala di Sekolah', 'Pelatih Klub Olahraga Sekolah', 'Pelatih Mental', 'Pelatih Olahraga', 'Pelatih Olahraga Akademi', 'Pelatih Olahraga Disabilitas', 'Pelatih Usia Dini', 'Penilai Parameter Tes Kondisi Fisik', 'Penyuluh', 'Perawat', 'Petugas Keamanan', 'Photographer', 'Psikolog Olahraga', 'Referee', 'Referee Observers', 'Representative', 'Responsible Team Official', 'Scorekeeper', 'Sport Announcer', 'Sport Masseur', 'Statistician Olahraga', 'Team Guide', 'Team Manager', 'Technical Delegates - Match', 'Technical Delegates - Official', 'Technical Director', 'Tenaga Keolahragaan', 'Tenaga Kesehatan', 'Tim Medis', 'Timekeeper', 'Trainer', 'Venue Director', 'Venue Manager', 'Volunteer', 'Volunteer Administrasi', 'Volunteer Event', 'Volunteer Media', 'Volunteer Medis', 'Volunteer Organisasi', 'Webmaster', 'Wheelchair Handball Classifier']
court_types = ['Indoor', 'Beach', 'Field', 'Wheelchair', 'Street']
event_formats = ['Single-Event', 'Multi-Event', 'Festival']
competition_levels = ['International', 'International - Continental', 'International - Regional', 'International - Open', 'National', 'Province', 'Cities/Regency']
participant_scopes = ['Antar Negara', 'Antar Provinsi', 'Antar Kota/Kab', 'Antar Universitas', 'Antar Pelajar', 'Antar Klub', 'Open']
age_categories = ['Jenjang Pelajar SD/Sederajat', 'Jenjang Pelajar SMP/Sederajat', 'Jenjang Pelajar SMA/Sederajat', 'Jenjang Pelajar Universitas/Sederajat', 'Open', 'Senior', 'U-23', 'U-22', 'U-21', 'U-20', 'U-19', 'U-18', 'U-17', 'U-16', 'U-15', 'U-14', 'U-13', 'U-12', 'U-11', 'U-10']
results = ['Panitia', 'Peserta', 'Peringkat 1', 'Peringkat 2', 'Peringkat 3', 'Peringkat 4', 'Peringkat 5', 'Peringkat 6', 'Peringkat 7', 'Peringkat 8', 'Peringkat 9', 'Peringkat 10', 'Peringkat 11', 'Peringkat 12', 'Peringkat 13', 'Peringkat 14', 'Peringkat 15', 'Peringkat 16']

# Add these new keys before the closing ];
new_keys = ""
new_keys += "    'event_roles' => " + json.dumps(event_roles) + ",\n"
new_keys += "    'court_types' => " + json.dumps(court_types) + ",\n"
new_keys += "    'event_formats' => " + json.dumps(event_formats) + ",\n"
new_keys += "    'competition_levels' => " + json.dumps(competition_levels) + ",\n"
new_keys += "    'participant_scopes' => " + json.dumps(participant_scopes) + ",\n"
new_keys += "    'age_categories' => " + json.dumps(age_categories) + ",\n"
new_keys += "    'results' => " + json.dumps(results) + ",\n"

# Replace '[' and ']' with array() or just keep []
new_keys = new_keys.replace('[', '[').replace(']', ']')

if 'event_roles' not in content:
    content = content.replace('\n];', ',\n' + new_keys + '];')

with open('config/dropdown.php', 'w', encoding='utf-8') as f:
    f.write(content)
print("Updated config/dropdown.php successfully!")
