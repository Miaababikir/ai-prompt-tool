import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Progress } from '@/Components/ui/progress';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { ChevronDown, ChevronUp } from 'lucide-react';
import { useState } from 'react';

interface Props {
    totalPromptsUsed: number;
    mostUsedPrompt: Array<{
        count: number;
        type: string;
    }>;
    averagePromptScores: {
        clarity: number;
        relevance: number;
        tone: number;
    };
    latestPromptSuggestions: Array<{
        type: string;
        relevance_suggestion: string;
        clarity_suggestion: string;
        tone_suggestion: string;
    }>;
}

export default function Dashboard({
    totalPromptsUsed,
    mostUsedPrompt,
    averagePromptScores,
    latestPromptSuggestions,
}: Props) {
    const [expandedRows, setExpandedRows] = useState<number[]>([]);

    const toggleRow = (index: number) => {
        setExpandedRows((prev) =>
            prev.includes(index)
                ? prev.filter((i) => i !== index)
                : [...prev, index],
        );
    };

    const truncateText = (text: string, maxLength: number) => {
        if (!text) {
            return '';
        }

        return `${text.substring(0, maxLength)}...`;
    };

    const getPromptTypeLabel = (type: string) => {
        if (type === 'video_title_generator') {
            return 'Generated video titles';
        }
        if (type === 'job_application_email_generator') {
            return 'Generated job application emails';
        }
        return 'Unknown';
    };

    const getScorePercentage = (score: number) => {
        return (score / 10) * 100;
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <Card>
                            <CardHeader>
                                <CardTitle>Total prompts usage</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <p className="text-3xl font-bold">
                                    {totalPromptsUsed}
                                </p>
                                <p className="text-muted-foreground text-xs">
                                    +2.5% from last month
                                </p>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader>
                                <CardTitle>Most Used Prompts</CardTitle>
                            </CardHeader>
                            <CardContent>
                                <ul className="space-y-2">
                                    {mostUsedPrompt.map((item, index) => (
                                        <li
                                            className="flex items-center justify-between"
                                            key={index}
                                        >
                                            <span className="text-sm font-medium">
                                                {getPromptTypeLabel(item.type)}
                                            </span>
                                            <span className="text-primary rounded-full bg-blue-400/10 px-2 py-1 text-xs">
                                                {item.count} uses
                                            </span>
                                        </li>
                                    ))}
                                </ul>
                            </CardContent>
                        </Card>
                    </div>

                    <div className="mt-4">
                        <Card>
                            <CardHeader>
                                <CardTitle>Average Prompt Scores</CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                <div>
                                    <div className="mb-1 flex justify-between">
                                        <span className="text-sm font-medium">
                                            Clarity
                                        </span>
                                        <span className="text-sm font-medium">
                                            {averagePromptScores.clarity}
                                        </span>
                                    </div>
                                    <Progress
                                        value={getScorePercentage(
                                            averagePromptScores.clarity,
                                        )}
                                        className="h-2"
                                    />
                                </div>
                                <div>
                                    <div className="mb-1 flex justify-between">
                                        <span className="text-sm font-medium">
                                            Relevance
                                        </span>
                                        <span className="text-sm font-medium">
                                            {averagePromptScores.relevance}
                                        </span>
                                    </div>
                                    <Progress
                                        value={getScorePercentage(
                                            averagePromptScores.relevance,
                                        )}
                                        className="h-2"
                                    />
                                </div>
                                <div>
                                    <div className="mb-1 flex justify-between">
                                        <span className="text-sm font-medium">
                                            Tone
                                        </span>
                                        <span className="text-sm font-medium">
                                            {averagePromptScores.tone}
                                        </span>
                                    </div>
                                    <Progress
                                        value={getScorePercentage(
                                            averagePromptScores.tone,
                                        )}
                                        className="h-2"
                                    />
                                </div>
                            </CardContent>
                        </Card>
                    </div>
                    <div className="mt-4">
                        <Card>
                            <CardHeader>
                                <CardTitle>
                                    Latest 5 Suggestions for Improving Prompt
                                    Design
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <Table className="w-full table-fixed">
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead className="w-1/12"></TableHead>
                                            <TableHead className="w-1/4">
                                                Prompt
                                            </TableHead>
                                            <TableHead className="w-1/4">
                                                Relevance suggestion
                                            </TableHead>
                                            <TableHead className="w-1/4">
                                                Clarity suggestion
                                            </TableHead>
                                            <TableHead className="w-1/4">
                                                Tone suggestion
                                            </TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        {latestPromptSuggestions.map(
                                            (item, index) => (
                                                <>
                                                    <TableRow
                                                        key={index}
                                                        className="hover:bg-muted/50 cursor-pointer"
                                                        onClick={() =>
                                                            toggleRow(index)
                                                        }
                                                    >
                                                        <TableCell className="w-1/12">
                                                            <Button
                                                                variant="ghost"
                                                                size="sm"
                                                            >
                                                                {expandedRows.includes(
                                                                    index,
                                                                ) ? (
                                                                    <ChevronUp className="h-4 w-4" />
                                                                ) : (
                                                                    <ChevronDown className="h-4 w-4" />
                                                                )}
                                                            </Button>
                                                        </TableCell>
                                                        <TableCell className="w-1/4 font-medium">
                                                            {getPromptTypeLabel(
                                                                item.type,
                                                            )}
                                                        </TableCell>
                                                        <TableCell className="w-1/4 truncate">
                                                            {truncateText(
                                                                item.relevance_suggestion,
                                                                50,
                                                            )}
                                                        </TableCell>
                                                        <TableCell className="w-1/4 truncate">
                                                            {truncateText(
                                                                item.clarity_suggestion,
                                                                50,
                                                            )}
                                                        </TableCell>
                                                        <TableCell className="w-1/4 truncate">
                                                            {truncateText(
                                                                item.tone_suggestion,
                                                                50,
                                                            )}
                                                        </TableCell>
                                                    </TableRow>
                                                    {expandedRows.includes(
                                                        index,
                                                    ) && (
                                                        <TableRow>
                                                            <TableCell
                                                                colSpan={5}
                                                                className="px-4"
                                                            >
                                                                <div className="grid grid-cols-3 gap-4 py-4">
                                                                    <div>
                                                                        <h4 className="mb-2 font-semibold">
                                                                            Relevance
                                                                            suggestion
                                                                        </h4>
                                                                        <p>
                                                                            {
                                                                                item.relevance_suggestion
                                                                            }
                                                                        </p>
                                                                    </div>
                                                                    <div>
                                                                        <h4 className="mb-2 font-semibold">
                                                                            Clarity
                                                                            suggestion
                                                                        </h4>
                                                                        <p>
                                                                            {
                                                                                item.clarity_suggestion
                                                                            }
                                                                        </p>
                                                                    </div>
                                                                    <div>
                                                                        <h4 className="mb-2 font-semibold">
                                                                            Tone
                                                                            suggestion
                                                                        </h4>
                                                                        <p>
                                                                            {
                                                                                item.tone_suggestion
                                                                            }
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </TableCell>
                                                        </TableRow>
                                                    )}
                                                </>
                                            ),
                                        )}
                                    </TableBody>
                                </Table>
                            </CardContent>
                        </Card>{' '}
                    </div>
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg"></div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
