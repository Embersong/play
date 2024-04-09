<?php

namespace App\Http\Controllers;

use App\Events\MatchEnded;
use App\Events\UserAdded;
use App\Exceptions\MatchEndedException;
use App\Exceptions\MatchFullException;
use App\Models\LotteryGame;
use App\Models\LotteryGameMatch;
use App\Models\LotteryGameMatchUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\UserAddedException;

class LotteryController extends Controller
{

    public function show(Request $request): JsonResponse
    {
        $rules = [
            'lottery_game_id' => 'required|int|exists:lottery_games,id',
        ];
        $input = $request->all();
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }
        $success['matches'] = LotteryGameMatch::where('game_id', $request->lottery_game_id)->get();
        return $this->sendResponse($success, 'Lottery matches');

    }

    public function addUser(Request $request): JsonResponse
    {
        $rules = [
            'match_id' => 'required|int|exists:lottery_game_matches,id',
        ];
        $input = $request->all();
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $user_id = Auth::id();
        $match_id = $request->match_id;

        $success['user_id'] = $user_id;
        $success['match_id'] = $match_id;

        try {
            event(new UserAdded($user_id, $match_id));
        } catch (UserAddedException $e) {
            return $this->sendError('You already added on this match.', [], 400);
        } catch (MatchFullException $e) {
            return $this->sendError('Match is full.', [], 400);
        }

        LotteryGameMatchUser::create([
            'user_id' => $user_id,
            'lottery_game_match_id' => $match_id,
        ]);


        return $this->sendResponse($success, 'User subscribed successfully');
    }

    public function update(Request $request): JsonResponse
    {

        $rules = [
            'match_id' => 'required|int|exists:lottery_game_matches,id',
        ];
        $input = $request->all();
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $match = LotteryGameMatch::find($request->match_id);

        if ($match->is_finished) {
            return $this->sendError('Match already finished');
        }

        try {
            event(new MatchEnded($match));
        } catch (MatchEndedException $e) {
            return $this->sendError('No users on this match.', [], 400);
        }




        $match->is_finished = true;
        $match->save();

        $success['match_id'] = $match->id;

        return $this->sendResponse($success, 'Match finished successfully');
    }

    public function create(Request $request): JsonResponse
    {

        $rules = [
            'game_id' => 'required|int|exists:lottery_games,id',
            'start_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',

        ];

        $input = $request->all();

        $validator = Validator::make($input, $rules);


        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $match = LotteryGameMatch::create($input);
        $success['match_id'] = $match->id;

        return $this->sendResponse($success, 'Match created successfully');


    }

    public function games(): JsonResponse
    {

        $gamesWithMatches = LotteryGame::with(['lotteryGameMatches' => function ($query) {
            $query->orderBy('start_date')->orderBy('start_time');
        }])->paginate(10);

        $success['games'] = $gamesWithMatches;
        return $this->sendResponse($success, 'Lottery games');

    }


}
