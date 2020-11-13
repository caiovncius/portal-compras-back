Segue pedido gerado no Portal Associados

Pedido: {{ $request->id }} <br>
Data da Solicitação: {{ \Illuminate\Support\Carbon::parse($request->created_at)->format('d/m/Y') }} <br>
Promoção: {{ $offer->name }} <br>
Condição: {{ $request->payment_method === 'TERM' ? 'À Prazo' : 'À vista' }} <br>
Valor: R$ {{ $request->total }} <br>
Fármacia: {{ $request->pharmacy->cnpj }} - {{ $request->pharmacy->name }} <br>
