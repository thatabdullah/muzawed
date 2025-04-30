<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subscription;
use Livewire\WithPagination;

class AccountSubscription extends Component
{
    use WithPagination;

    public $account;
    public $showForm = false;
    public $editingId = null;
    public $form = [
        'saas_product_id' => '',
        'start_date' => '',
        'end_date' => '',
        'price' => ''
    ];

    protected $rules = [
        'form.saas_product_id' => 'required|exists:products,id',
        'form.start_date' => 'required|date',
        'form.end_date' => 'nullable|date|after:form.start_date',
        'form.price' => 'nullable|numeric|min:0'
    ];

    public function mount()
    {
        $this->account = optional(auth()->user())->account;
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->editingId = null;
        $this->reset('form');
    }

    public function saveSubscription()
    {
        $this->validate();

        $data = [
            'account_id' => $this->account->id,
            ...$this->form
        ];

        if ($this->editingId) {
            Subscription::find($this->editingId)->update($data);
        } else {
            Subscription::create($data);
        }

        $this->toggleForm();
    }

    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id);
        $this->editingId = $id;
        $this->form = $subscription->only(['saas_product_id', 'start_date', 'end_date', 'price']);
        $this->showForm = true;
    }

    public function delete($id)
    {
        Subscription::findOrFail($id)->delete();
    }

    public function render()
    {
        if (!$this->account) {
            return view('livewire.account-subscription', [
                'subscriptions' => collect(),
                'noAccount' => true
            ]);
        }
    
        $subscriptions = Subscription::where('account_id', $this->account->id)
            ->with('product')
            ->latest()
            ->paginate(5);
    
        return view('livewire.account-subscription', [
            'subscriptions' => $subscriptions,
            'noAccount' => false
        ]);
    }
}