<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiaryRequest;
use App\Http\Resources\DiaryRecourse;
use App\Models\Diary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function user_id()
    {
        if (Auth::check()) {
            return Auth::user()->id;
        } else {
            return null;
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Diary::where('user_id', $this->user_id())->get();
            return DiaryRecourse::collection($data);
        }
        return view('diary.index');
    }

    public function store(DiaryRequest $request)
    {
        $data = Diary::updateOrCreate(['id' => $request->diary_id], [
            'user_id' => $this->user_id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return response()->json($data);
    }

    public function show(Diary $diary)
    {
        return $diary;
    }

    public function destroy($id)
    {
        $data = Diary::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Diary deleted',
        ], 200);
    }
}
