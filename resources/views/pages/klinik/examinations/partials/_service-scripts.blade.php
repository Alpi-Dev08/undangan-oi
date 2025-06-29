@push('customscript')
<script>
    /**
     * Service form functionality
     * Handles ICD-10 assessment integration
     */
    $(function(){
        // Store original assessment content
        let originalAssessment = $("#assessment").html();
        
        /**
         * Handle ICD-10 selection change
         * Appends selected ICD-10 text to assessment field
         */
        $("#icdtens").change(function(){
            let selectedText = $(this).find("option:selected").text();
            if (selectedText && selectedText !== '') {
                $("#assessment").append(selectedText + '\n');
                console.log('ICD-10 added to assessment:', selectedText);
            }
        });
        
        /**
         * Reset assessment to original state
         */
        function resetAssessment() {
            $("#assessment").html(originalAssessment);
            console.log('Assessment reset to original state');
        }
        
        // Make reset function globally available
        window.resetAssessment = resetAssessment;
        
        console.log('Service form scripts initialized');
    });
</script>
@endpush