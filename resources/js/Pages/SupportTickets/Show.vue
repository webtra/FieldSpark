<template>
    <AppLayout title="Support Tickets">
        <div>
            <!-- Ticket Details Table -->
            <div class="rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm text-black">
                    <thead class="bg-white border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium w-24 whitespace-nowrap">ID</th>
                            <th class="px-4 py-4 text-left text-xs font-medium w-32 whitespace-nowrap">Ticket #</th>
                            <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">Category</th>
                            <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">Urgency</th>
                            <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">Status</th>
                            <th class="px-4 py-4 text-left text-xs font-medium w-40 whitespace-nowrap">Created</th>
                            <th class="px-4 py-4 text-left text-xs font-medium w-20 whitespace-nowrap">Updated</th>
                            <th class="px-6 py-4 text-right text-xs font-medium w-40 whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 w-24 text-xs text-gray-600">{{ ticket.id }}</td>
                            <td class="px-4 py-4 w-32 text-xs text-gray-600">{{ ticket.ticket_number }}</td>
                            <td class="px-4 py-4 w-40 text-xs text-gray-600">{{ ticket.category }}</td>
                            <td class="px-4 py-4 w-40 text-xs text-gray-600">{{ ticket.urgency }}</td>
                            <td class="px-4 py-4 w-40 text-xs text-gray-600">{{ ticket.status }}</td>
                            <td class="px-4 py-4 w-40 text-xs text-gray-600">{{ formattedUpdatedAt(ticket.created_at) }}
                            </td>
                            <td class="px-4 py-4 w-20 text-right text-xs text-gray-500">{{
                                formattedUpdatedAt(ticket.updated_at) }}</td>

                            <td class="px-6 py-4 w-40 text-right text-xs text-gray-500">
                                <div v-if="!ticket.is_closed">
                                    <DangerButton @click="closeTicket" :disabled="ticket.status === 'Closed'"
                                        :class="{ 'opacity-50 cursor-not-allowed': ticket.status === 'Closed' }">
                                        Close Ticket
                                    </DangerButton>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <!-- Reply Form -->
                <div>
                    <div class="rounded-t-lg overflow-x-auto mt-4">
                        <table class="min-w-full text-sm text-black">
                            <thead class="bg-white border-b-2 border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium whitespace-nowrap">
                                        Respond
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="rounded-b-lg overflow-x-auto">
                        <div class="min-w-full text-sm text-black">
                            <div class="bg-white border-gray-200 px-6 py-4 w-full text-xs text-gray-600">
                                <div v-if="ticket.status !== 'Closed'">
                                    <div class="mb-4">
                                        <TextArea id="reply_content" name="reply_content" v-model="replyContent"
                                            class="w-full !border-gray-200" placeholder="Leave a Reply" rows="6"
                                            required />
                                    </div>
                                    <div class="flex justify-end">
                                        <PrimaryButton type="submit" class="w-fit" @click.prevent="submitReply">
                                            Submit Reply
                                        </PrimaryButton>
                                    </div>
                                </div>
                                <p v-else class="text-gray-500 italic">This ticket is closed.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Display Initial Ticket Message and Replies -->
                <div>
                    <!-- Initial Ticket Message -->
                    <div class="rounded-lg overflow-x-auto my-4">
                        <table class="min-w-full text-sm text-black">
                            <thead class="bg-white border-b-2 border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium whitespace-nowrap">
                                        Message
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 w-full text-xs text-gray-600">
                                        {{ ticket.message }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Replies Section with Role-based Styling -->
                    <div class="rounded-lg overflow-x-auto">
                        <table class="min-w-full text-sm text-black">
                            <thead class="bg-white border-b-2 border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium whitespace-nowrap">
                                        Responses
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Loop through replies, with conditional classes for admin/user roles -->
                                <tr v-if="ticket.replies && ticket.replies.length > 0" v-for="reply in ticket.replies"
                                    :key="reply.id">
                                    <td :class="{ 'border-l-4 border-blue-600': reply.user.role === 'admin', 'border-l-4 border-gray-300': reply.user.role === 'user' }"
                                        class="px-6 py-4 w-full text-xs text-gray-600">
                                        <div class="font-semibold">
                                            {{ reply.user ? reply.user.first_name + ' ' + reply.user.last_name : 'User'
                                            }}
                                        </div>
                                        <div class="text-gray-600">{{ reply.reply_message }}</div>
                                        <div class="text-gray-400 text-xs mt-1">
                                            {{ formattedUpdatedAt(reply.created_at) }}
                                        </div>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td class="px-6 py-4 w-full text-xs text-gray-500 italic">
                                        No responses yet.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import { toast } from 'vue3-toastify';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import DangerButton from '@/Components/DangerButton.vue';

// Extract ticket ID from the URL
const url = new URL(window.location.href);
const ticketId = parseInt(url.pathname.split('/').pop());

// Define props for ticket data
const props = defineProps({
    ticket: {
        type: Object,
        required: true,
    },
});

// New data for reply form
const replyContent = ref('');

// Function to submit the reply
const submitReply = async () => {
    try {
        const payload = {
            reply_message: replyContent.value,
        };

        const response = await axios.post(`/support-tickets/${ticketId}/reply`, payload);
        toast("Reply submitted successfully!", { theme: "colored", type: "success", position: "top-center", hideProgressBar: true });

        // Update replies immediately on the frontend
        props.ticket.replies.unshift(response.data.reply);
        replyContent.value = ''; // Clear reply content
    } catch (error) {
        toast("Error submitting reply!", { theme: "colored", type: "error", position: "top-center", hideProgressBar: true });
        toast.error('Error submitting reply');
    }
};

// Function to format the date
const formattedUpdatedAt = (dateString) => {
    const date = new Date(dateString);
    const formattedDate = date.toLocaleDateString('en-GB');
    const formattedTime = date.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
    return `${formattedDate} ${formattedTime}`;
};

// Function to change the ticket status to closed
const closeTicket = async () => {
    try {
        await axios.post(`/support-tickets/${ticketId}/close`);
        toast("Ticket closed successfully!", { theme: "colored", type: "success", position: "top-center", hideProgressBar: true });
        props.ticket.is_closed = true;
        props.ticket.status = 'Closed';
    } catch (error) {
        toast("Error closing ticket!", { theme: "colored", type: "error", position: "top-center", hideProgressBar: true });
        toast.error('Error closing ticket');
    }
};
</script>
