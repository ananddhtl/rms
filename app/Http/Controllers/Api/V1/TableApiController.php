<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseApiController;
use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\TableReservation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Api\TableResource;
use App\Http\Resources\Api\ReserveTableResource;

class TableApiController extends BaseApiController
{
    public function __invoke(Request $request)
    {
        try {
            $tables = Table::query()->with('reservation')->get();

            return $this->sendResponse(TableResource::collection($tables), 'Table fetched successfully!');
        } catch (Exception $e) {
            return $this->sendError('Something went wrong');
        }
    }

    public function tableReservation(Request $request)
    {
        try {
            DB::beginTransaction();

            $table = Table::findOrFail($request->id);

            $table_reservation = new TableReservation([
                'user_id' => auth('api')->user()->id,
                'table_id' => $table->id,
                'date' => $request->date,
                'time' => $request->time,
                'guest_count' => $request->guest_count,
            ]);
            $table_reservation->save();

            $table->status = true;
            $table->save();

            DB::commit();
            return $this->sendResponse($table_reservation, 'Reserved Successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError('Something went wrong');
        }
    }

    public function unReserveTable(Request $request)
    {
        try {
            DB::beginTransaction();

            $table_reservation = TableReservation::findOrFail($request->table_reservation_id);
            $table_reservation->is_complete = true;
            
            $table = Table::findOrFail($table_reservation->table_id);
            $table->status = false;
            $table->save();
            
            $table_reservation->delete();

            DB::commit();
            return $this->sendResponse($table_reservation, 'UnReserved Successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->sendError('Something went wrong');
        }
    }

    public function getAvailableTable()
    {
        try {
            $tables = Table::where('status', 0)->with('reservation')->get();

            return $this->sendResponse(TableResource::collection($tables), 'Table fetched successfully!');
        } catch (Exception $e) {

            return $this->sendError('Something went wrong');
        }
    }

    public function getMyReservedTables()
{
    try {
        
        $reserved_tables = auth('api')->user()->tableReservation()->where('is_complete', 0)->get();

       
        $reserved_tables->load('user', 'table');

        
        $reserved_tables_resource = ReserveTableResource::collection($reserved_tables);

        return $this->sendResponse($reserved_tables_resource, 'Reserved tables fetched successfully!');
    } catch (Exception $e) {
      dd($e->getMessage());
        \Log::error('Error fetching reserved tables: ' . $e->getMessage());
        
        return $this->sendError('Something went wrong.');
    }
}
}
