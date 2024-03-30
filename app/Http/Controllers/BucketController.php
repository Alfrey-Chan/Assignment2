<?php

namespace App\Http\Controllers;

use App\Models\Bucket;
use App\Rules\UniqueVendorCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BucketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buckets = Bucket::orderBy('id', 'asc')->paginate(10);
        $headers = Schema::getColumnListing('buckets');

        return view('bucket.index', [
            'buckets' => $buckets,
            'headers' => $headers,
        ])->with(request()->input('page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bucket.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate function will redirect the user to previous location if any checks fail
        $validatedData = self::validateBucket($request);

        try {
            Bucket::createBucket($validatedData);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('bucket.index')
            ->with('success', 'Bucket added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bucket $bucket)
    {
        return view('bucket.edit', ['bucket' => $bucket]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bucket $bucket)
    {
        self::validateBucket($request);

        try {
            Bucket::updateBucket($bucket, $request);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('bucket.index')
            ->with('success', 'Bucket updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bucket $bucket)
    {
        $bucket->delete();

        return redirect()
            ->route('bucket.index')
            ->with('success', 'Transaction deleted successfully.');
    }

    private function validateBucket(Request $request)
    {
        return $request->validate([
            'vendor' => 'required|string',
            'category' => [
                'required',
                'string',
                new UniqueVendorCategory($request->vendor, $request->category),
            ],
        ]);
    }
}
