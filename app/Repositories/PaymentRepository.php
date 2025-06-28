<?php

namespace App\Repositories;
use App\Interface\PaymentInterface;
use App\Models\FeeType;
use App\Models\Payment;
use App\Models\PaymentDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
class PaymentRepository implements PaymentInterface
{

	public function create(array $data): \Illuminate\Database\Eloquent\Model|null
	{
		$dataFees = $data['fees']; // masih berbentuk array
		$code = $this->generateCode($dataFees);
		$totalMonthMap = $this->calculateStartDateEndDate($dataFees);
		// dd($data['house_id']);
		// Buat pembayaran utama
		$payment = Payment::create([
			'code' => $code,
			'house_id' => $data['house_id'],
			'resident_id' => $data['resident_id'],
			'status' => $data['status'],
			'description' => $data['description'] ?? null,
		]);

		// Loop setiap jenis iuran
		foreach ($dataFees as $feeId => $feeData) {
			$feeType = FeeType::find($feeId);
			if (!$feeType) {
				continue;
			}

			// Set tanggal mulai dan akhir
			$startDate = Carbon::createFromDate($feeData['start_year'], $feeData['start_month'], 1);
			$endDate = Carbon::createFromDate($feeData['end_year'], $feeData['end_month'], 1);

			// Hitung total bulan dan total harga
			$totalMonths = $totalMonthMap[$feeId] ?? 0;
			$totalAmount = $feeType->amount * $totalMonths;

			// Simpan ke payment_details per bulan
			while ($startDate->lessThanOrEqualTo($endDate)) {
				PaymentDetail::create([
					'payment_id' => $payment->id,
					'fee_type_id' => $feeType->id,
					'amount' => $feeType->amount,
					'month' => $startDate->month,
					'year' => $startDate->year,
				]);
				$startDate->addMonth();
			}
		}

		return $payment;
	}


	public function find($id): \Illuminate\Database\Eloquent\Model|null
	{
		// TODO: Implement find() method.
		return Payment::find($id);
	}

	public function getAll(): \Illuminate\Database\Eloquent\Collection
	{
		// TODO: Implement getAll() method.
		return Payment::with(['resident.currentHouse.house', 'paymentDetail'])->get();
	}

	public function update(array $data, $id): \Illuminate\Database\Eloquent\Model|null
	{
		// TODO: Implement update() method.
		// update
		return Payment::find($id);
	}
	public function updateStatus($id){
		$payment = Payment::find($id);
		$payment->update([
			'status' => 'lunas'
		]);
		return $payment;
	}

	public function delete($id): void
	{
		// TODO: Implement delete() method.
		Payment::find($id)->delete();
	}

	public function get(string $id): \Illuminate\Database\Eloquent\Model|null
	{
		// TODO: Implement get() method.
		return Payment::find($id);
	}
	public function generateCode(array $fees): string
	{
		$codeParts = [];
		foreach ($fees as $feeId => $feeData) {
			// Ambil FeeType berdasarkan ID
			$feeType = FeeType::find($feeId);
			if ($feeType) {
				// Ambil huruf awal dari nama FeeType
				$initial = strtoupper(substr($feeType->name, 0, 1));
				// Tambahkan huruf awal ke dalam array
				$codeParts[] = $initial;
			}
		}
		// Gabungkan huruf awal dengan string acak
		$randomString = Str::random(5); // Menghasilkan string acak sepanjang 5 karakter
		$code = implode('', $codeParts) . $randomString;
		return $code;
	}
	public function calculateStartDateEndDate(array $array): array
	{
		$results = [];
		foreach ($array as $feeId => $feeData) {
			// Ambil bulan dan tahun mulai
			$startMonth = (int) $feeData['start_month'];
			$startYear = (int) $feeData['start_year'];
			// Ambil bulan dan tahun akhir
			$endMonth = (int) $feeData['end_month'];
			$endYear = (int) $feeData['end_year'];
			// Hitung jumlah bulan dari start ke end
			$totalMonths = ($endYear - $startYear) * 12 + ($endMonth - $startMonth) + 1;
			// Simpan hasil dalam array
			$results[$feeId] = $totalMonths;
		}
		return $results;
	}
	public function paymentByFeeType(string $id): array
	{
		// Get payment data with required relationships
		$payment = Payment::with([
			'resident.currentHouse.house',
			'house',
			'paymentDetail.feeType'
		])->findOrFail($id);

		// Group by fee type name
		// Group by fee type name
		$groupedDetails = $payment->paymentDetail
			->groupBy(function ($detail) {
				return $detail->feeType->name;
			})
			->map(function ($items, $key) {
				$total = $items->sum('amount');

				// Ambil detail dengan kombinasi year dan month paling akhir
				$lastDetail = $items->sortByDesc(function ($item) {
					return $item->year * 100 + $item->month;
				})->first();

				return [
					'name' => $key,
					'details' => $items,
					'total' => $total,
					'last_month' => $lastDetail->month,
					'last_year' => $lastDetail->year,
				];
			});


		// Calculate grand total by summing all fee type totals
		$grandTotal = $groupedDetails->sum('total');

		return [
			'payment' => $payment,
			'groupedDetails' => $groupedDetails,
			'grandTotal' => $grandTotal,
		];
	}



}