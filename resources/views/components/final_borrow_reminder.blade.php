<p>Bonjour {{ $borrow->borrowerProfile->name }},</p>
<p>Ce message est un dernier rappel. Le livre <strong>{{ $borrow->book->title }}</strong> n'a pas encore été retourné et la date limite de retour était le {{ $borrow->due_date->format('d/m/Y') }}.</p>
<p>Veuillez retourner le livre au plus vite.</p>
