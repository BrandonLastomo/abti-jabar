import csv

results = {}

with open('atlet.csv', encoding='utf-8') as f:
    reader = csv.reader(f)
    for i, row in enumerate(reader):
        for j, cell in enumerate(row):
            if '(Dropdown)' in cell:
                # The cell text might be "Nomor (Dropdown) Indoor Beach Field Wheelchair Street"
                header, *choices = cell.split('(Dropdown)')
                if choices:
                    choices_str = choices[0].strip()
                    results[header.strip()] = [c for c in choices_str.split(' ') if c]

for k, v in results.items():
    print(k, ":", v)
