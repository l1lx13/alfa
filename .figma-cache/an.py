import json, sys
nid, name = sys.argv[1], sys.argv[2]
d = json.load(open(f'.figma-cache/p-{name}.json'))
n = list(d['nodes'].values())[0]['document']
base = n['absoluteBoundingBox']['y']
print('===', name, n['name'], int(n['absoluteBoundingBox']['height']))
for c in n['children']:
    bb = c.get('absoluteBoundingBox') or {}
    y = int(bb.get('y', 0) - base)
    if y > 6200:
        continue
    print(f"  {c['type']:<9} {str(c.get('name'))[:36]:<36} y={y:>5} h={int(bb.get('height',0)):>5} w={int(bb.get('width',0)):>5}")
out = []
def walk(x):
    for c in x.get('children', []):
        if c.get('type') == 'TEXT':
            st = c.get('style') or {}
            bb = c.get('absoluteBoundingBox') or {}
            y = round(bb.get('y', 0) - base)
            if y < 6200:
                out.append((y, round(st.get('fontSize', 0)), st.get('fontWeight'), (c.get('characters') or '').replace('\n', ' / ')))
        walk(c)
walk(n)
print('  --- texts:')
for y, fs, fw, t in sorted(out):
    print(f'   {y:>5} {fs:<5} {fw} | {t[:120]}')
