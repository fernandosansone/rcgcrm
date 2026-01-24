<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Contact::class);

        $q = trim((string) $request->query('q', ''));

        $contacts = Contact::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('first_name', 'like', "%{$q}%")
                        ->orWhere('last_name', 'like', "%{$q}%")
                        ->orWhere('company_name', 'like', "%{$q}%")
                        ->orWhere('email_1', 'like', "%{$q}%")
                        ->orWhere('phone_1', 'like', "%{$q}%");
                });
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(15)
            ->withQueryString();

        return view('contacts.index', compact('contacts','q'));
    }

    public function create()
    {
        Gate::authorize('create', Contact::class);

        return view('contacts.create');
    }

    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;

        Contact::create($data);

        return redirect()->route('contacts.index')->with('success', 'Contacto creado.');
    }

    public function quickStore(Request $request)
    {
        Gate::authorize('create', \App\Models\Contact::class);

        $data = $request->validate([
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['required','string','max:100'],
            'company_name' => ['nullable','string','max:191'],
            'email_1'    => ['nullable','email','max:191'],
            'phone_1'    => ['nullable','string','max:30'],
        ]);

        $data['created_by'] = $request->user()->id;

        $contact = \App\Models\Contact::create($data);

        $label = $contact->last_name . ', ' . $contact->first_name;
        if ($contact->company_name) $label .= ' — ' . $contact->company_name;

        return response()->json([
            'id' => $contact->id,
            'label' => $label,
        ]);
    }

    public function edit(Contact $contact)
    {
        Gate::authorize('update', $contact);

        return view('contacts.edit', compact('contact'));
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        Gate::authorize('update', $contact);

        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        $contact->update($data);

        return redirect()->route('contacts.index')->with('success', 'Contacto actualizado.');
    }

    public function destroy(Contact $contact)
    {
        Gate::authorize('delete', $contact);

        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Contacto eliminado.');
    }

    // Opcional: show
    public function show(Contact $contact)
    {
        $Gate::authorize('view', $contact);

        return view('contacts.show', compact('contact'));
    }
}
