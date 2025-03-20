<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending MLCE Recommendations</title>
    <style>
        /* 1. Use a more-intuitive box-sizing model */
        *, *::before, *::after {
            box-sizing: border-box;
        }

        /* 2. Remove default margin */
        * {
            margin: 0;
        }

        body {
            /* 3. Add accessible line-height */
            line-height: 1.5;
            /* 4. Improve text rendering */
            -webkit-font-smoothing: antialiased;
        }

        /* 5. Improve media defaults */
        img, picture, video, canvas, svg {
            display: block;
            max-width: 100%;
        }

        /* 6. Inherit fonts for form controls */
        input, button, textarea, select {
            font: inherit;
        }

        /* 7. Avoid text overflows */
        p, h1, h2, h3, h4, h5, h6 {
            overflow-wrap: break-word;
        }

        /* 8. Improve line wrapping */
        p {
            text-wrap: pretty;
        }

        h1, h2, h3, h4, h5, h6 {
            text-wrap: balance;
        }

        /*
          9. Create a root stacking context
        */
        #root, #__next {
            isolation: isolate;
        }

        body {
            font-family: Arial, sans-serif;
            /*line-height: 1.6;*/
            color: #333;
            max-width: 720px;
            margin: 0 auto;
            padding: 32px 16px;
        }

        h1 {
            font-size: 1.5rem;
        }

        h2 {
            font-size: 20px;
        }

        h3 {
            font-size: 18px;
        }

        .header {
            /*text-align: center;*/
            margin-bottom: 32px;
        }

        section {
            margin-bottom: 24px;
        }

        .indent-info {
            background-color: #f5f5f5;
            padding: 16px 20px;
            margin-left: -20px;
            margin-right: -20px;
            border-radius: 4px;
        }

        .two-col {
            display: grid;
            grid-template-columns: 1fr 3fr;
        }

        .location-section {
            margin-bottom: 32px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }

        /*.recommendation {*/
        /*    background-color: #fff;*/
        /*    padding: 16px;*/
        /*    margin-bottom: 24px;*/
        /*    margin-left: -16px;*/
        /*    margin-right: -16px;*/
        /*    !*border-left: 4px solid #ffa500;*!*/
        /*    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);*/
        /*}*/

        .priority-box {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .row {
            line-height: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 12px;
            /*font-size: 1rem;*/
            padding-left: 16px;
            padding-right: 16px;
            padding-bottom: 12px;
            /*border-bottom: 1px solid #ddd;*/
            margin-left: -16px;
            margin-right: -16px;
        }

        .row:last-of-type {
            margin-bottom: revert;
            /*border-bottom: revert;*/
            /*padding-bottom: revert;*/
        }

        .row h5 {
            font-size: 1rem;
        }

        .row p {
            font-size: 1rem;
            padding-left: 24px;
        }

        .priority-tag {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }

        .high {
            background-color: #ff4500;
        }

        .medium {
            background-color: #ffa500;
        }

        .low {
            background-color: #3cb371;
        }

        /* Existing styles */
        .recommendation {
            background-color: #fff;
            margin-left: -16px;
            margin-right: -16px;
            margin-bottom: 24px;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding-bottom: 8px;
        }

        .high-priority {
            border-top: 4px solid #ff4500;
        }

        .medium-priority {
            border-top: 4px solid #ffa500;
        }

        .low-priority {
            border-top: 4px solid #3cb371;
        }

        /* New styles */
        .recommendation-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #eee;
        }

        .recommendation-meta {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            /*margin-bottom: 10px;*/
        }

        .recommendation-title {
            margin: 8px 0;
            font-size: 16px;
        }

        .recommendation-content {
            padding: 16px 20px;
        }

        .content-section {
            margin-bottom: 20px;
        }

        .content-section:last-child {
            margin-bottom: 0;
        }

        .content-title {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 8px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
            color: #333;
        }

        .content-body {
            font-size: 14px;
            line-height: 1.6;
            color: #444;
            /*white-space: pre-line;*/
            /*max-height: 300px;*/
            /*overflow-y: auto;*/
            /*padding: 5px 3px;*/
        }

        /* Keep priority tag styles */
        .priority-tag {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }

        .timeline {
            font-weight: bold;
            color: #555;
            font-size: 14px;
        }
    </style>
</head>
<body>
<header class="header">
    <h1>Pending MLCE Recommendations</h1>
</header>
<main>
    <section class="indent-info">
        <h2 style="margin-bottom: 12px">Indent Information</h2>
        <p class="two-col"><strong>Reference Number:</strong> <span>{{ $data['indent']->ref_no }}</span></p>
        <p class="two-col"><strong>Policy Number:</strong> <span>{{ $data['indent']->policy_no }}</span></p>
        <p class="two-col"><strong>Customer:</strong> <span>{{ $data['customer']->name }}</span></p>
    </section>

    <section class="user-info">
        <p>Dear <strong>{{ $user->name }}</strong>,</p>

        <p>This email serves as a reminder of pending recommendations that require attention for the above indent.
            Please review
            the following details:</p>
    </section>


    @foreach($data['recommendationsByLocation'] as $locationId => $recommendations)
        @php
            $location = $recommendations->first()->mlceAssignment->mlceIndentLocation;

            $priorityMap = ['High' => 3, 'Medium' => 2, 'Low' => 1];
            $sortedRecommendations = $recommendations->sortByDesc(function ($recommendation) use ($priorityMap) {
                return $priorityMap[$recommendation->closure_priority] ?? 0;
            })
        @endphp
        <section class="location-section">
            <h3>Location - <span>{{ $location->location }}</span></h3>
            <p class="two-col"><strong>Address:</strong> <span>{{ $location->address }}</span></p>
            <p class="two-col" style="margin-bottom: 24px"><strong>SPOC:</strong> <span>{{ $location->spoc_name }}
            ({{ $location->spoc_mobile_no }})</span></p>

            <h4 style="margin-bottom: 12px; font-size: 18px">
                Pending Recommendations ({{ $sortedRecommendations->count()}})
            </h4>

            @foreach($sortedRecommendations as $recommendation)
                <div class="recommendation {{ strtolower($recommendation->closure_priority) }}-priority">
                    <!-- Header section with priority and timeline -->
                    <div class="recommendation-header">
                        <h4 class="recommendation-title">Location: {{ $recommendation->location}}</h4>
                        <div class="recommendation-meta">
                            <span class="timeline">Timeline: {{ $recommendation->timeline }}</span>
                            <span class="priority-tag {{ strtolower($recommendation->closure_priority) }}">
                {{ $recommendation->closure_priority }} Priority
            </span>
                        </div>

                    </div>

                    <!-- Content section for longer text -->
                    <div class="recommendation-content">
                        <div class="content-section">
                            <h5 class="content-title">Brief</h5>
                            <div class="content-body">
                                {!! nl2br(e($recommendation->brief)) !!}
                            </div>
                        </div>

                        <div class="content-section">
                            <h5 class="content-title">Current Observation</h5>
                            <div class="content-body">
                                {!! nl2br(e($recommendation->current_observation)) !!}
                            </div>
                        </div>

                        @if($recommendation->hazard)
                            <div class="content-section">
                                <h5 class="content-title">Potential Hazard</h5>
                                <div class="content-body">
                                    {!! nl2br(e($recommendation->hazard)) !!}
                                </div>
                            </div>
                        @endif

                        <div class="content-section">
                            <h5 class="content-title">Recommendation</h5>
                            <div class="content-body">
                                {!! nl2br(e($recommendation->recommendations)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    @endforeach
</main>
<footer>
    <p>Please take appropriate action on these recommendations according to their priority and timeline. You can view
        and
        manage these recommendations through the MLCE portal.</p>

    <p>Thank you for your attention to this matter.</p>
    <br/>
    <p>Best regards,<br>
        {{config("app.name")}}</p>

    <br/>

</footer>


</body>
</html>
