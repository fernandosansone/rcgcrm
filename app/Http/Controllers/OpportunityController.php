<?php

namespace App\Http\Controllers;

use App\Enums\OpportunityStatus;
use App\Http\Requests\StoreOpportunityRequest;
use App\Http\Requests\UpdateOpportunityRequest;
use App\Models\Contact;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OpportunityController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Opportunity::class);

        $q = trim((string) $request->query('q', ''));
        $status = trim((string) $request->query('status', ''));

        $opportunities = Opportunity::query()
            ->with(['contact', 'assignedUser'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where('detail', 'like', "%{$q}%")
                    ->orWhereHas('contact', function ($c) use ($q) {
                        $c->where('first_name', 'like', "%{$q}%")
                          ->orWhere('last_name', 'like', "%{$q}%")
                          ->orWhere('company_name', 'like', "%{$q}%");
                    });
            })
            ->when($status !== '', fn($query) => $query->where('status', $status))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $statuses = OpportunityStatus::values();

        return view('opportunities.index', compact('opportunities', 'q', 'status', 'statuses'));
    }

    public function create()
    {
        Gate::authorize('create', Opportunity::class);

        $contacts = Contact::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get(['id','first_name','last_name','company_name']);

        $statuses = OpportunityStatus::values();

        return view('opportunities.create', compact('contacts', 'statuses'));
    }

    public function store(StoreOpportunityRequest $request)
    {
        $data = $request->validated();

        // B) asignado al usuario logueado
        $data['assigned_user_id'] = $request->user()->id;
        $data['created_by'] = $request->user()->id;

        Opportunity::create($data);

        return redirect()->route('opportunities.index')->with('success', 'Oportunidad creada.');
    }

    public function edit(Opportunity $opportunity)
    {
        Gate::authorize('update', $opportunity);

        $contacts = Contact::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get(['id','first_name','last_name','company_name']);

        $statuses = OpportunityStatus::values();

        return view('opportunities.edit', compact('opportunity', 'contacts', 'statuses'));
    }

    public function update(UpdateOpportunityRequest $request, Opportunity $opportunity)
    {
        Gate::authorize('update', $opportunity);

        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        $opportunity->update($data);

        return redirect()->route('opportunities.index')->with('success', 'Oportunidad actualizada.');
    }

    public function destroy(Opportunity $opportunity)
    {
        Gate::authorize('delete', $opportunity);

        $opportunity->delete();

        return redirect()->route('opportunities.index')->with('success', 'Oportunidad eliminada.');
    }
}
