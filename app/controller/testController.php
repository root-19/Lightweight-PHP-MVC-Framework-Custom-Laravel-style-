<?php

class testController {

    public function index() {
        // Display a listing of the resource
        echo "testController controller index method.";
    }

    public function create() {
        // Show the form for creating a new resource
        echo "testController controller create method.";
    }

    public function store() {
        // Store a newly created resource in storage
        echo "testController controller store method.";
    }

    public function show($id) {
        // Display the specified resource
        echo "testController controller show method for ID: $id";
    }

    public function edit($id) {
        // Show the form for editing the specified resource
        echo "testController controller edit method for ID: $id";
    }

    public function update($id) {
        // Update the specified resource in storage
        echo "testController controller update method for ID: $id";
    }

    public function destroy($id) {
        // Remove the specified resource from storage
        echo "testController controller destroy method for ID: $id";
    }
}
