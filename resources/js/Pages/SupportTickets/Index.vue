<template>
    <AppLayout title="Support Tickets">
        <div class="overflow-x-hidden overflow-y-auto">
            <div class="block md:flex items-center justify-between mb-4">
                <p class="text-sm mt-1 text-black font-medium"><span class="font-bold">Total Tickets:</span> {{ filteredTickets.length }} (Filtered from {{ supportTicketsCount }})
                    </p>

                <div class="mt-4 md:mt-0 flex items-center space-x-2 md:space-x-4">
                    <!-- Search Bar -->
                    <TextInput type="text" v-model="search" placeholder="Search" class="w-full md:w-96" />

                    <div class="w-full md:w-fit">
                        <PrimaryButton @click="showCreateTicketModal = true">
                            Create Ticket
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Modal for Creating a Support Ticket -->
            <div v-if="showCreateTicketModal" class="fixed z-50 inset-0 flex items-center justify-center">
                <div class="fixed inset-0 bg-black opacity-50"></div>
                <div class="relative bg-white rounded p-6 w-full max-w-sm z-50 space-y-4">
                    <h3 class="text-lg font-semibold mb-4">Create New Support Ticket</h3>

                    <div class="w-full">
                        <InputLabel value="Category" />
                        <select v-model="formData.category" class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded" required>
                            <option value="Feature Request">Feature Request</option>
                            <option value="Technical Issue">Technical Issue</option>
                            <option value="Billing/Payment">Billing/Payment</option>
                            <option value="Account Access">Account Access</option>
                            <option value="Feedback">Feedback</option>
                            <option value="Usability Issue">Usability Issue</option>
                            <option value="Product Inquiry">Product Inquiry</option>
                            <option value="Security">Security</option>
                            <option value="Upgrade/Downgrade Request">Upgrade/Downgrade Request</option>
                            <option value="General Inquiry">General Inquiry</option>
                        </select>
                    </div>

                    <div class="w-full">
                        <InputLabel value="Urgency" />
                        <select v-model="formData.urgency" class="w-full text-xs mt-1 placeholder:text-xs border-gray-300 focus:border-[#BCDA84] focus:ring-[#BCDA84] rounded" required>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                            <option value="Critical">Critical</option>
                        </select>
                    </div>

                    <div class="w-full">
                        <InputLabel value="Subject" />
                        <TextInput id="subject" type="text" v-model="formData.subject" class="mt-1 block w-full" placeholder="Subject" required />
                    </div>

                    <div class="w-full">
                        <InputLabel value="Message" />
                        <TextArea id="message" type="text" v-model="formData.message" class="mt-1 block w-full" placeholder="Message" required />
                    </div>

                    <div class="mt-6 text-gray-500 flex justify-end space-x-4">
                        <CancelButton @click="showCreateTicketModal = false">Cancel</CancelButton>
                        <PrimaryButton @click="createTicket">Create</PrimaryButton>
                    </div>
                </div>
            </div>

            <!-- Table of Support Tickets -->
            <div class="mt-4" v-if="paginatedTickets && paginatedTickets.length > 0">
                <div class="rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm text-black">
                        <thead class="bg-white border-b-2 border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium w-28 whitespace-nowrap">ID</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">Ticket Number</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">Category</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">Urgency</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">Status</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">Subject</th>
                                <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">Created</th>
                                <th class="px-6 py-4 text-right text-xs font-medium w-28 whitespace-nowrap">Updated</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="ticket in paginatedTickets" :key="ticket.id" class="cursor-pointer" @click="viewTicket(ticket.id)">
                                <td class="px-6 py-4 w-28 text-xs text-gray-600">{{ ticket.id }}</td>
                                <td class="px-4 py-4 w-40 text-xs text-gray-600">{{ ticket.ticket_number }}</td>
                                <td class="px-4 py-4 w-40 text-xs text-gray-600">{{ ticket.category }}</td>
                                <td class="px-4 py-4 w-40 text-xs text-gray-600">{{ ticket.urgency }}</td>
                                <td class="px-4 py-4 w-40 text-xs text-gray-600">{{ ticket.status }}</td>
                                <td class="px-4 py-4 w-40 text-xs text-gray-600">{{ ticket.subject }}</td>
                                <td class="px-4 py-4 w-40 text-xs text-gray-600 line-clamp-1">{{ formattedUpdatedAt(ticket.created_at) }}</td>
                                <td class="px-6 py-4 w-28 text-right text-xs text-gray-500">{{ formattedUpdatedAt(ticket.updated_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Load More Button -->
                <div class="flex justify-center mt-4">
                    <button v-if="displayedItems < filteredTickets.length" @click="loadMore" class="px-4 py-2 rounded bg-[#BCDA84] hover:bg-green-600">Load More</button>
                </div>
            </div>

            <!-- If no tickets found -->
            <div v-else>
                <p>No support tickets found</p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { toast } from 'vue3-toastify';
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from "@/Components/InputLabel.vue";
import CancelButton from "@/Components/CancelButton.vue";
import DangerButton from '@/Components/DangerButton.vue';
import TextArea from '@/Components/TextArea.vue';

const { supportTickets, supportTicketsCount } = defineProps({
    supportTickets: Array,
    supportTicketsCount: Number,
});

const showCreateTicketModal = ref(false);
const search = ref('');
const displayedItems = ref(10);

const formattedUpdatedAt = (updatedAt) => {
    const date = new Date(updatedAt);
    const formattedDate = date.toLocaleDateString('en-GB');
    const formattedTime = date.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
    return `${formattedDate} ${formattedTime}`;
};

// Computed property for filtered tickets based on search term
const filteredTickets = computed(() => {
    if (!search.value) return supportTickets;

    return supportTickets.filter((ticket) => {
        return (
            ticket.id.toString().includes(search.value) ||
            ticket.subject.toLowerCase().includes(search.value.toLowerCase()) ||
            ticket.category.toLowerCase().includes(search.value.toLowerCase()) ||
            ticket.urgency.toLowerCase().includes(search.value.toLowerCase())
        );
    });
});

// Computed property for paginated tickets, limited by displayedItems
const paginatedTickets = computed(() => {
    return filteredTickets.value.slice(0, displayedItems.value);
});

// Function to load more tickets
const loadMore = () => {
    displayedItems.value += 10;
};

const formData = ref({
    category: '',
    urgency: '',
    subject: '',
    message: '',
    status: '',
});

const createTicket = async () => {
    try {
        const response = await axios.post('/support-tickets/store', formData.value);

        toast("Record sucessfully crated!", { theme: "colored", type: "success", position: "top-center", hideProgressBar: true });

        // Close the modal
        showCreateTicketModal.value = false;

        // Reset the form data
        formData.value = {
            category: '',
            urgency: '',
            subject: '',
            message: '',
            status: 'Open', // default status
        };

        // Add the newly created ticket to the list if you want to see the update immediately
        supportTickets.push(response.data.ticket); // Adjust if supportTickets is not directly mutable

    } catch (error) {
        console.error('Error creating ticket:', error);
        toast.error('Failed to create support ticket');
    }
};

const viewTicket = (ticketId) => {
    // Navigate to the show page of the selected ticket
    window.location.href = `/support-tickets/${ticketId}`;
};
</script>
