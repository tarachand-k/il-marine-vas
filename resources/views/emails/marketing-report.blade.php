@component('mail::message')
# MLCE Report Details

Here are the MLCE details for Reference No: {{ $marketing->ref_no }}

## Basic Information
- **VAS Type**: {{ $marketing->vas_type }}
- **Category**: {{ $marketing->cat }}
- **Policy No**: {{ $marketing->policy_no }}
- **Policy Period**: {{ $marketing->policy_start_date }} to {{ $marketing->policy_end_date }}
- **Account**: {{ $marketing->account }}

## Additional Details
- **Account Type**: {{ $marketing->account_type }}
- **Industry**: {{ $marketing->industry }}
- **Is MNC**: {{ $marketing->is_mnc ? 'Yes' : 'No' }}
- **Year**: {{ $marketing->year }}
- **Quarter**: {{ $marketing->quarter }}
- **Month**: {{ $marketing->month }}

## Sales Information
- **Sales RM Name**: {{ $marketing->sales_rm_name }}
- **Sales Band 1**: {{ $marketing->sales_band_1 }}
- **Claims Manager**: {{ $marketing->claims_manager }}

Thanks,
{{ config('app.name') }}
@endcomponent
