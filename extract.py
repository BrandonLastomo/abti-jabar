import urllib.request
import re

url = "https://docs.google.com/spreadsheets/d/11Snlq-M7ld89MisLLFB_HtKuf-P8BN_5znlgkzNSdHo/edit?usp=sharing"
html = urllib.request.urlopen(url).read().decode('utf-8')

# Search for the GID inside the bootstrapData block
# Often formatted like: "DIPAKAI - DROPDOWN ALAMAT TINGGAL DAN LAHIR", ..., ..., "123456789"
matches = re.findall(r'\["DIPAKAI - DROPDOWN ALAMAT TINGGAL DAN LAHIR",\d+,[^\]]+\]', html)
print("Regex 1:", matches)

# Try another pattern where GID is before or after
idx = html.find('DIPAKAI - DROPDOWN ALAMAT TINGGAL DAN LAHIR')
if idx != -1:
    context = html[max(0, idx-200):idx+200]
    # find all numbers in this context
    print("Numbers near the name:", re.findall(r'\b\d{6,15}\b', context))
# --- Merged from extract_tabs and extract_tabs2 ---
html_path = r'C:\Users\brand\.gemini\antigravity-ide\brain\f88ed4e8-8aaf-4d66-af64-994ad325fe44\.system_generated\steps\1157\content.md'
with open(html_path, 'r', encoding='utf-8') as f:
    local_html = f.read()

# Try to find all sheet names and gids
# The structure usually looks like: [ "Sheet Name", 12345678 ] or {"name": "Sheet Name", "gid": "12345678"}
matches1 = re.findall(r'\["([^"]+)",(\d+)\]', local_html)
matches2 = re.findall(r'"name":"([^"]+)","gid":"?(\d+)"?', local_html)
matches3 = re.findall(r'\\?\"name\\?\":\\?\"(.*?)\\?\",\\?\"gid\\?\":\\?\"?(\d+)\\?', local_html)

all_matches = set(matches1 + matches2 + matches3)
print("Found tabs from local html:")
for name, gid in all_matches:
    print(f"Name: {name}, GID: {gid}")
