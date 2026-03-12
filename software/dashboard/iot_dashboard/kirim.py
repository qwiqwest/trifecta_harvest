import requests

url = "https://smartharvest.online/assets/php/api_insert.php"

payload = {
    "a1": 1,
    "a2": 1,
    "b1": 1,
    "b2": 1
}

headers = {
    "User-Agent": "Mozilla/5.0",
    "Accept": "*/*"
}

r = requests.post(
    url,
    data=payload,
    headers=headers,
    timeout=15,
    allow_redirects=True
)

print(r.status_code)
print(r.text)
