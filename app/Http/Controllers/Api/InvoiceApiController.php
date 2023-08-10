<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\TicketEmail;
use App\Models\Barcodes;
use App\Models\Invoice;
use App\Models\Orders;
use App\Models\User;
use Dompdf\Dompdf;
use Hash;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Ramsey\Uuid\Uuid;
use View;

class InvoiceApiController extends Controller
{
    // Function to Create Order
    public function createOrder(Request $request)
    {
        // Validate the request
        $request->validate([
            'order_id' => 'nullable',
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'required|numeric|min:1',
            'total_amount' => 'required|numeric|min:1',
            'username' => 'required|min:3|max:255|alpha_dash',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        // check if order_id is already exists or not if exists then return the response
        if ($request->order_id != null) {
            $order = Invoice::find($request->order_id);
            if ($order) {
                return response()->json([
                    'message' => 'Order Already Exists',
                    'order' => $order,
                ]);
            }
        }

        // check if user_id is null
        if ($request->user_id == null) {
            // Find user by email
            $user = User::where('email', $request->email)->first();
            // If user not found then create new user
            if (!$user) {
                $user = User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'mobile' => $request->phone,
                    'password' => Hash::make('password'),
                ]);
            }
            // Assign user_id
            $request->user_id = $user->id;
        }

        // Create Order
        $order = Invoice::create([
            'user_id' => $request->user_id,
            'ticket_id' => $request->ticket_id,
            'quantity' => $request->quantity,
            'total_amount' => $request->total_amount,
            'is_paid' => false,
        ]);

        // Return the response
        return response()->json([
            'message' => 'Order Created Successfully',
            'order_id' => $order->id,
        ]);
    }

    // Function to update order status
    public function updateOrderStatus($status, Request $request)
    {
        // Validate the request
        $request->validate([
            'order_id' => 'required',
        ]);

        // Update Order Status
        $order = Invoice::find($request->order_id);
        $order->status = $status;
        $order->save();

        // Return the response
        return response()->json([
            'message' => 'Order Status Updated Successfully',
            'order' => $order,
        ]);
    }

    // Function to Insert Payment Details
    public function paymentDetails(Request $request)
    {
        // Validate the request
        $request->validate([
            'order_id' => 'required',
            'billing_token' => 'required',
            'payment_amount' => 'required',
            'facilitator_access_token' => 'nullable',
            'paypal_order_id' => 'required',
            'payer_id' => 'required',
            'payer_name' => 'nullable',
            'payer_email' => 'nullable',
            'payer_address' => 'nullable',
            'gross_amount' => 'required',
            'status' => 'required',
        ]);

        // Insert Payment Details
        $order = Invoice::find($request->order_id);
        $order->payment()->create([
            'order_id' => $request->order_id,
            'billing_token' => $request->billing_token,
            'payment_amount' => $request->payment_amount,
            'facilitator_access_token' => $request->facilitator_access_token,
            'paypal_order_id' => $request->paypal_order_id,
            'payer_id' => $request->payer_id,
            'payer_name' => $request->payer_name,
            'payer_email' => $request->payer_email,
            'payer_address' => $request->payer_address,
            'gross_amount' => $request->gross_amount,
            'status' => $request->status,
        ]);

        // Generate A Barcode For The Order
        // Create a new BarcodeGenerator instance for PNG images
        $barcodeGenerator = new BarcodeGeneratorPNG();
        // generate a unique barcode value using GUID library
        $barcodeValue = Uuid::uuid4()->toString();
        // Generate the barcode image based on the provided value
        $barcodeImage = $barcodeGenerator->getBarcode($barcodeValue, $barcodeGenerator::TYPE_CODE_128);

        // Save the barcode image to the public directory
        $imagePath = 'barcodes/' . $barcodeValue . '.png';
        file_put_contents(public_path($imagePath), $barcodeImage);

        /* QR Code is not working  */
        // $qrCode = QrCode::size(300)->generate($barcodeValue);
        // $qrCodePath = 'qrcodes/' . $barcodeValue . '.png';
        // Storage::disk('public')->put($qrCodePath, $qrCode);
        // file_put_contents(public_path($qrCodePath), $qrCode);

        // Insert Barcode Details
        $barcode = Barcodes::create([
            'invoice_id' => $request->order_id,
            'barcode_id' => $barcodeValue,
            'barcode_img' => $imagePath,
        ]);

        // Generate A Invoice For The Order
        // Data for the invoice and barcode
        $invoiceData = ['invoiceNumber' => 'INV12345', 'amount' => '$100.00'];
        $barcodeValue = $invoiceData['invoiceNumber'];

        // Create a BarcodeGenerator instance for PNG images
        $barcodeGenerator = new BarcodeGeneratorPNG();
        $barcodeImage = $barcodeGenerator->getBarcode($barcodeValue, $barcodeGenerator::TYPE_CODE_128);

        // Load the PDF template with data
        $pdf = new Dompdf();
        $pdf->loadHtml(View::make('pdf.invoice', compact('invoiceData', 'barcodeImage')));
        $pdf->setPaper('A4', 'portrait'); // Set paper size and orientation
        $pdf->render();

        // Save the PDF to a public path or return as response
        $pdfPath = public_path("invoices/$barcodeValue.pdf"); // Change the path and filename as needed
        file_put_contents($pdfPath, $pdf->output());

        // Send Email To The User With Barcode Image Attached
         \Mail::to($order->user->email)->send(new TicketEmail("invoices/$barcodeValue.pdf"));

        // Update Order Status
        $order->status = '1';

        // Return the response
        return response()->json([
            'message' => 'Payment Details Inserted Successfully',
            'order' => $order->load('payment')->payment,
        ]);
    }
}
