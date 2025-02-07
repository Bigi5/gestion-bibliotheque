<p>Bonjour {{ $borrow->borrowerProfile->name }},</p>
<p>Ce message vous rappelle que le livre <strong>{{ $borrow->book->title }}</strong> est prévu pour être retourné dans deux jours, le {{ $borrow->due_date->format('d/m/Y') }}.</p>
<p>Merci de bien vouloir le retourner dans les délais.</p>
