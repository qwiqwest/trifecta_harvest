import requests

url = "http://smartharvest.page.gd/api_insert.php"

data = {
    "hasil": 1,
    "persentase": 87
}

headers = {
    "User-Agent": "Mozilla/5.0",
    "Accept": "*/*",
    "Connection": "keep-alive"
}

r = requests.post(url, data=data, headers=headers)

print(r.text)
