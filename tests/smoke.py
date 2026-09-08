import re,time,sys,urllib.request,urllib.parse,urllib.error,http.cookiejar
class Response:
 def __init__(self,r): self.status_code=r.code;self.text=r.read().decode('utf-8')
class Session:
 def __init__(self):self.opener=urllib.request.build_opener(urllib.request.HTTPCookieProcessor(http.cookiejar.CookieJar()))
 def req(self,url,data=None):
  try:return Response(self.opener.open(url,urllib.parse.urlencode(data).encode() if data is not None else None))
  except urllib.error.HTTPError as e:return Response(e)
 def get(self,url):return self.req(url)
 def post(self,url,data):return self.req(url,data)

s=Session();base=(sys.argv[1] if len(sys.argv)>1 else 'http://127.0.0.1:8080').rstrip('/')+'/'
def get(path):
 r=s.get(base+path);assert 'Fatal error' not in r.text and '<b>Warning' not in r.text,(path,r.text[:500]);return r
def post(path,data):
 t=re.search(r'name="csrf" value="([^"]+)',get('detalhes.php?ID=2344').text).group(1);return s.post(base+path,data=dict(data,csrf=t))
assert get('detalhes.php?ID=999999').status_code==404
assert 'Produto indisponível' in get('detalhes.php?ID=2326').text
post('add_carrinho.php',{'produto':2326,'quantidade':1})
assert 'Seu carrinho está vazio' in get('carrinho.php').text
assert get('../config/database.example.php').status_code==404
assert s.post(base+'add_carrinho.php',data={'produto':2344}).status_code==403
post('add_carrinho.php',{'produto':2344,'quantidade':2});post('add_carrinho.php',{'produto':2343,'quantidade':1})
assert '1.228,00' in get('carrinho.php').text
post('removeCarrinho.php',{'id':2344});assert 'R$ 30,00' in get('carrinho.php').text and '2 un.' not in get('carrinho.php').text
stamp=str(int(time.time()));email='teste'+stamp+'@example.invalid';cpf='9'+stamp[-10:]
r=post('cadastro.php',{'nome':'Teste Automatizado','cpf':cpf,'email':email,'senha':'TesteLocal!2026','confirmar':'TesteLocal!2026'});assert 'Olá,' in r.text,r.text[:400]
r=post('confirma_venda.php',{'cep':'123','endereco':'Rua Teste','numero':'1','bairro':'Teste','cidade':'Teste','uf':'SP','forma_pagto':'Boleto'});assert 'Confira o endereço' in r.text
r=post('confirma_venda.php',{'cep':'01001000','endereco':'Rua de Teste','numero':'123','bairro':'Teste','cidade':'São Paulo','uf':'SP','forma_pagto':'Cartão','parcelas':'3','valor_total':'0.01'});assert 'Pedido de teste confirmado!' in r.text,r.text[-1500:];assert 'R$ 30,00' in r.text
assert 'Seu carrinho está vazio' in get('carrinho.php').text
get('sair.php');r=post('login.php',{'login':email,'senha':'TesteLocal!2026'});assert 'Sua conta' not in r.text or 'Fatal error' not in r.text
assert 'Você já está conectado.' in get('login.php').text
assert 'Resultados para' in get('index.php?busca=mouse').text
print('PASS: search, missing product, CSRF, quantities, remove, signup, address validation, server totals, order, cart reset, login')

