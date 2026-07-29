<?php
namespace App\Livewire\Auth;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
class Register extends Component { public string $name='';public string $email='';public string $password='';public string $password_confirmation=''; public function register(){ $d=$this->validate(['name'=>['required','string','max:255'],'email'=>['required','email','unique:users,email'],'password'=>['required','min:8','same:password_confirmation']]); $u=User::create(['name'=>$d['name'],'email'=>$d['email'],'password'=>Hash::make($d['password'])]); foreach([['Salário','income'],['Freelance','income'],['Investimentos','income'],['Moradia','expense'],['Alimentação','expense'],['Transporte','expense'],['Saúde','expense'],['Lazer','expense'],['Assinaturas','expense']] as [$name,$type]) Category::create(['user_id'=>$u->id,'name'=>$name,'type'=>$type]); Auth::login($u); return $this->redirectRoute('dashboard',navigate:true); } public function render(){return view('livewire.auth.register')->layout('layouts.auth');} }
