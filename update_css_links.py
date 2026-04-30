from pathlib import Path
root = Path(r'c:\xampp\htdocs\miniprojet')
count = 0
for path in sorted(root.glob('*.php')):
    text = path.read_text(encoding='utf-8')
    if 'href="style.css"' in text or "href='style.css'" in text:
        continue
    if '<head>' not in text or '</head>' not in text:
        continue
    new_text = text
    if '<meta charset' not in text.lower():
        new_text = new_text.replace(
            '<head>',
            '<head>\n    <meta charset="UTF-8">\n    <meta name="viewport" content="width=device-width, initial-scale=1.0">',
            1,
        )
    if 'href="style.css"' not in new_text and "href='style.css'" not in new_text:
        new_text = new_text.replace(
            '</head>',
            '    <link rel="stylesheet" href="style.css">\n</head>',
            1,
        )
    if new_text != text:
        path.write_text(new_text, encoding='utf-8')
        count += 1
        print(f'Updated {path.name}')
print('Done:', count, 'files updated')
