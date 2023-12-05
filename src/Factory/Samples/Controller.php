<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Sienekib\Mehael\Http\Request;
use Sienekib\Mehael\Database\Factory\DB;

class {controller} extends Controller
{

	public function index()
	{
		$data = [];

		// TODO: coloque o seu código

		return view('titulo:caminho.da.tela', compact('data'));
	}

	// Cria um registo na DB

	public function store(Request $request)
	{
		// TODO: coloqe o seu código

		return redirect()->route('rota.de.redirecionamento');
	}

	// Pega um registo(s) na DB

	public function read(Request $request)
	{
		$data = [];

		// TODO: coloqe o seu código

		return response()->json($data);
	}

	// Atualizações de um ou + registos na DB

	public function update(Request $request)
	{
		// TODO: coloqe o seu código

		$this->sms->system_error('mensagem'); // esse vai vir do controller

		return redirect()->backWith('success', 'mensagem de sucesso');
	}

	// Apaga um registo na DB

	public function delete(Request $request)
	{
		DB::table('tabela')->where('id', '=', $request->id)->delete();

		// TODO: coloqe o seu código

		return redirect()->back();
	}
}
